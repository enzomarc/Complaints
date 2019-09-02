<?php
	
	namespace App\Http\Controllers;
	
	use App\Unity;
	use Illuminate\Http\Request;
	use Mockery\Exception;
	
	class UnityController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$unities = Unity::all();
			$user = auth()->user();
			
			return view('administrator.unities', compact('user', 'unities'));
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
				'name' => 'required'
			]);
			
			$data = $request->except('_token');
			$unity = new Unity($data);
			
			try {
				if ($unity->saveOrFail())
					return response()->json(['message' => 'Unité créée avec succès.', 'unity' => $unity], 201);
				else
					return response()->json(['message' => 'Impossible de créer l\'unité.']);
			} catch (\Exception $e) {
				return response()->json(['message' => 'Une erreur est survenue lors de la création de l\'unité.', 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param \App\Unity $unity
		 * @return \Illuminate\Http\Response
		 */
		public function show(Unity $unity)
		{
			return response(['unity' => $unity]);
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param \App\Unity $unity
		 * @return \Illuminate\Http\Response
		 */
		public function edit(Unity $unity)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \App\Unity $unity
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, Unity $unity)
		{
			try {
				$name = $request->input('name');
				
				if ($unity->update(['name' => $name]))
					return response()->json(['message' => 'Unité modifiée avec succès.', 'unity' => $unity]);
				else
					return response()->json(['message' => "Impossible de modifier l'unité."]);
			} catch (\Exception $e) {
				return response()->json(['message' => "Une erreur est survenue lors de la modification de l'unité.", 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param \App\Unity $unity
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Unity $unity)
		{
			$name = $unity->name;
			
			try {
				if ($unity->delete())
					return response()->json(['message' => "L'unité $name a été supprimée."]);
				else
					return response()->json(['message' => "Impossible de supprimer l'unité."]);
			} catch (\Exception $e) {
				return response()->json(['message' => "Erreur lors de la suppression de l'unité.", 'exception' => $e->getMessage()], 500);
			}
		}
	}
