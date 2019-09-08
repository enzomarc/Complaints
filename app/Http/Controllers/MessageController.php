<?php
	
	namespace App\Http\Controllers;
	
	use App\Message;
	use App\User;
	use Illuminate\Http\Request;
	
	class MessageController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			//
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
		 * @param Request $request
		 * @return \Illuminate\Http\JsonResponse
		 * @throws \Illuminate\Validation\ValidationException
		 * @throws \Throwable
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'to' => 'required|numeric',
				'content' => 'required'
			]);
			
			$data = $request->except('_token');
			$data['from'] = auth()->user()->id;
			$message = new Message($data);
			
			try {
				$message->saveOrFail();
				$user = User::find($message->to);
				
				return response()->json(['message' => "Votre message a bien été envoyé à " . $user->first_name . ' ' . $user->last_name], 201);
			} catch (\Exception $e) {
				return response()->json(['message' => "Une erreur est survenue lors de l'envoie du message.", 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param \App\Message $message
		 * @return \Illuminate\Http\Response
		 */
		public function show(Message $message)
		{
			//
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param \App\Message $message
		 * @return \Illuminate\Http\Response
		 */
		public function edit(Message $message)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \App\Message $message
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, Message $message)
		{
			//
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param \App\Message $message
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Message $message)
		{
			//
		}
	}
