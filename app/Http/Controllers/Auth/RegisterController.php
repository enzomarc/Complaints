<?php
	
	namespace App\Http\Controllers\Auth;
	
	use App\User;
	use App\Http\Controllers\Controller;
	use Exception;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Foundation\Auth\RegistersUsers;
	
	class RegisterController extends Controller
	{
		/*
		|--------------------------------------------------------------------------
		| Register Controller
		|--------------------------------------------------------------------------
		|
		| This controller handles the registration of new users as well as their
		| validation and creation. By default this controller uses a trait to
		| provide this functionality without requiring any additional code.
		|
		*/
		
		use RegistersUsers;
		
		/**
		 * Where to redirect users after registration.
		 *
		 * @var string
		 */
		protected $redirectTo = '/';
		
		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		public function __construct()
		{
			$this->middleware('guest');
		}
		
		/**
		 * Show registration page.
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function register()
		{
			if (auth()->check())
				return redirect()->route('dashboard');
			
			return view('register');
		}
		
		/**
		 * Create user account.
		 *
		 * @param Request $request
		 * @return \Illuminate\Http\JsonResponse
		 * @throws \Illuminate\Validation\ValidationException
		 * @throws \Throwable
		 */
		public function create(Request $request)
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
				
				return response()->json(['message' => 'Le compte utilisateur a été créé avec succès.', 'user' => $user], 201);
			} catch (Exception $e) {
				return response()->json(['message' => 'Une erreur s\'est produite lors de la création du compte. Contactez l\'administrateur.', 'exception' => $e->getMessage()], 500);
			}
		}
	}
