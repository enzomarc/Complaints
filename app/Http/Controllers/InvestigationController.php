<?php
	
	namespace App\Http\Controllers;
	
	use App\Complaint;
	use App\Investigation;
	use App\User;
	use Illuminate\Http\Request;
	
	class InvestigationController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$user = auth()->user();
			$investigations = Investigation::all()->where('investigator', $user->id);
			
			$investigations->transform(function (Investigation $investigation) {
				$complaint = Complaint::find($investigation->complaint);
				$investigation->author = User::find($complaint->author);
				
				return $investigation;
			});
			
			return view('investigator.investigations', compact('investigations', 'user'));
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
		 * Store newly created resource.
		 *
		 * @param Request $request
		 * @return \Illuminate\Http\JsonResponse
		 * @throws \Illuminate\Validation\ValidationException
		 * @throws \Throwable
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'complaint' => 'required',
				'reason' => 'required',
				'start_date' => 'required',
				'end_date' => 'required'
			]);
			
			$data = $request->except('_token');
			$data['investigator'] = auth()->user()->id;
			
			try {
				$investigation = new Investigation($data);
				
				if ($investigation->saveOrFail())
					return response()->json(['message' => "Une nouvelle enquête a été ouverte pour la plainte n°$investigation->complaint.", 'investigation' => $investigation], 201);
				else
					return response()->json(['message' => "Impossible d'ouvrir une enquête pour cette plainte."], 500);
			} catch (\Exception $e) {
				return response()->json(['message' => "Une erreur est survenue lors de l'ouverture de l'enquête.", 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param \App\Investigation $investigation
		 * @return \Illuminate\Http\Response
		 */
		public function show(Investigation $investigation)
		{
			return response()->json(['investigation' => $investigation]);
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param \App\Investigation $investigation
		 * @return \Illuminate\Http\Response
		 */
		public function edit(Investigation $investigation)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request $request
		 * @param Investigation $investigation
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function update(Request $request, Investigation $investigation)
		{
			$data = $request->except('_token');
			
			try {
				if ($investigation->update($data))
					return response()->json(['message' => "Enquête mise à jour avec succès.", 'investigation' => $investigation]);
				else
					return response()->json(['message' => "Une erreur est survenue lors de la mise à jour de l'enquête."], 500);
			} catch (\Exception $e) {
				return response()->json(['message' => "Une erreur est survenue lors de la mise à jour de l'enquête.", 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param \App\Investigation $investigation
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Investigation $investigation)
		{
			try {
				$investigation->delete();
				
				return response()->json(['message' => 'Enquête supprimée avec succès.']);
			} catch (\Exception $e) {
				return response()->json(['message' => "Une erreur est survenue lors de la suppression de l'enquête. Contactez l'administrateur."], 500);
			}
		}
	}
