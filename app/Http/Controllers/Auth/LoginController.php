<?php
	
	namespace App\Http\Controllers\Auth;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Foundation\Auth\AuthenticatesUsers;
	use Illuminate\Http\Request;
	use \Exception;
	
	class LoginController extends Controller
	{
		/*
		|--------------------------------------------------------------------------
		| Login Controller
		|--------------------------------------------------------------------------
		|
		| This controller handles authenticating users for the application and
		| redirecting them to your home screen. The controller uses a trait
		| to conveniently provide its functionality to your applications.
		|
		*/
		
		use AuthenticatesUsers;
		
		/**
		 * Where to redirect users after login.
		 *
		 * @var string
		 */
		protected $redirectTo = '/';
		
		/**
		 * Get the login username to be used by the controller.
		 *
		 * @return string
		 */
		public function username()
		{
			return 'phone';
		}
		
		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		public function __construct()
		{
			$this->middleware('guest')->except('logout');
		}
		
		/**
		 * Show login page.
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function login()
		{
			if (auth()->check())
				return redirect()->route('dashboard');
			
			return view('login');
		}
		
		/**
		 * Authenticate user.
		 *
		 * @param Request $request
		 * @return \Illuminate\Http\JsonResponse
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function auth(Request $request)
		{
			$this->validate($request, [
				'phone' => 'required|numeric',
				'password' => 'required'
			]);
			
			$credentials = $request->only(['phone', 'password']);
			
			try {
				if (auth()->attempt($credentials)) {
					if (auth()->user()->active) {
						$name = auth()->user()->first_name;
						
						return response()->json(['message' => "Bienvenue sur votre tableau de bord $name.", 'user' => auth()->user()]);
					} else
						return response()->json(['message' => 'Votre compte est désactivé, veuillez contacter l\'administrateur.'], 401);
				} else {
					return response()->json(['message' => 'Numéro de téléphone ou mot de passe incorrect.'], 401);
				}
			} catch (Exception $e) {
				return response()->json(['message' => 'Une erreur est survenue lors de la connexion. Veuillez réessayer.', 'exception' => $e->getMessage()], 500);
			}
		}
		
		/**
		 * Logout user.
		 *
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function logout()
		{
			auth()->logout();
			
			return redirect()->route('login');
		}
	}
