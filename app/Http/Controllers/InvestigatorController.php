<?php
	
	namespace App\Http\Controllers;
	
	use App\Unity;
	use App\User;
	use Exception;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;
	
	class InvestigatorController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$investigators = User::all()->where('type', 1);
			$unities = Unity::all();
			$user = auth()->user();
			
			return view('investigator.index', compact('investigators', 'user', 'unities'));
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			//
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'first_name' => 'required',
				'date_of_birth' => 'required',
				'birthplace' => 'required',
				'gender' => 'required',
				'phone' => 'required|numeric',
				'password' => 'required',
				'type' => 'required|numeric'
			]);
			
			$data = $request->except('_token');
			$data['password'] = Hash::make($data['password']);
			
			$user = new User($data);
			
			try {
				$user->saveOrFail();
				
				return response()->json(['message' => 'L\'enquêteur a été créé avec succès.', 'user' => $user], 201);
			} catch (Exception $e) {
				return response()->json(['message' => 'Une erreur s\'est produite lors de la création du compte. Contactez l\'administrateur.', 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			try {
				$investigator = User::findOrFail($id);
				$investigator->date_of_birth = date_format(new \DateTime($investigator->date_of_birth), 'Y-m-d');
				
				return response()->json(['investigator' => $investigator]);
			} catch (Exception $e) {
				return response()->json(['message' => "Impossible de trouver l'enquêteur spécifié.", 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			try {
				$investigator = User::findOrFail($id);
				return response()->json(['message' => 'Data is here!', 'data' => $request->input()]);
				
				$data = $request->except('_token');
				$investigator->update($data);
				
				return response()->json(['message' => "Enquêteur mis à jour avec succès.", 'investigator' => $investigator]);
			} catch (Exception $e) {
				return response()->json(['message' => "Une erreur est survenue lors de la mise à jour.", 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			try {
				$investigator = User::findOrFail($id);
				
				if ($investigator->delete())
					return response()->json(['message' => 'Enquêteur supprimé avec succès.']);
				else
					return response()->json(['message' => 'Impossible de supprimer l\'enquêteur sélectionné.'], 500);
			} catch (Exception $e) {
				return response()->json(['message' => "Une erreur est survenue lors de la suppression de l'enquêteur.", 'exception' => $e->getMessage()], 500);
			}
		}
	}
