<?php
	
	namespace App\Http\Controllers;
	
	use App\Complaint;
	use App\Investigation;
	use App\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Str;
	
	class ComplaintController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$complaints = Complaint::with('author')->get();
			$user = auth()->user();
			
			$complaints->transform(function (Complaint $complaint) {
				$complaint->author = User::find($complaint->author);
				$complaint->investigated = Investigation::all()->where('complaint', $complaint->id)->count() > 0;
				
				return $complaint;
			});
			
			return view('investigator.complaints', compact('complaints', 'user'));
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			$logged = auth()->check();
			
			return view('user.complaint_create', compact('logged'));
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param Request $request
		 * @return \Illuminate\Http\JsonResponse
		 * @throws \Illuminate\Validation\ValidationException
		 * @throws \Throwable
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'suspect' => 'required',
				'description' => 'required',
			]);
			
			$author = null;
			$password = null;
			
			if (!auth()->check()) {
				$exists = User::all()->where('phone', $request->input('phone'))->first();
				
				if ($exists == null) {
					$this->validate($request, [
						'first_name' => 'required',
						'last_name' => 'required',
						'date_of_birth' => 'required',
						'birthplace' => 'required',
						'gender' => 'required',
						'phone' => 'required'
					]);
					
					$user_data = $request->except(['suspect', 'description']);
					$user_data['date_of_birth'] = date('Y-m-d h:i:s', strtotime($user_data['date_of_birth']));
					$password = Str::random(8);
					$user_data['password'] = Hash::make($password);
					$user = new User($user_data);
					
					try {
						$user->saveOrFail();
						$author = $user->id;
						auth()->login($user);
					} catch (\Exception $e) {
						return response()->json(['message' => "Impossible d'enregistrer votre plainte. Si vous avez déjà un compte, veuillez vous connecter et réessayer.", 'exception' => $e->getMessage()], 500);
					}
				} else {
					auth()->login($exists);
					$password = 'exists';
					$author = $exists->id;
				}
			} else {
				$author = auth()->user()->id;
			}
			
			$data = $request->only(['suspect', 'description']);
			$data['author'] = $author;
			
			try {
				$complaint = new Complaint($data);
				$complaint->saveOrFail();
				$message = "Votre plainte a été enregistrée. Cliquez sur le bouton continuer pour accéder à votre tableau de bord où vous pourrez suivre l'évolution de votre plainte.";
				
				if ($password == null || $password == 'exists')
					return response()->json(['message' => $message], 201);
				else
					return response()->json(['message' => $message, 'password' => $password], 201);
			} catch (\Exception $e) {
				return response()->json(['message' => "Une erreur est survenue lors de l'enregistrement de votre plainte.", 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param \App\Complaint $complaint
		 * @return \Illuminate\Http\Response
		 */
		public function show(Complaint $complaint)
		{
			return response()->json(['complaint' => $complaint]);
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param \App\Complaint $complaint
		 * @return \Illuminate\Http\Response
		 */
		public function edit(Complaint $complaint)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \App\Complaint $complaint
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, Complaint $complaint)
		{
			$data = $request->except('_token');
			
			try {
				$complaint->update($data);
				
				return response()->json(['message' => 'Plainte mise à jour avec succès.', 'complaint' => $complaint]);
			} catch (\Exception $e) {
				return response()->json(['message' => 'Erreur lors de la mise à jour de la plainte.', 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param \App\Complaint $complaint
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Complaint $complaint)
		{
			try {
				$complaint->delete();
				
				return response()->json(['message' => 'Plainte supprimée avec succès.']);
			} catch (\Exception $e) {
				return response()->json(['message' => 'Erreur lors de la suppression de la plainte.', 'exception' => $e->getMessage()], 500);
			}
		}
	}
