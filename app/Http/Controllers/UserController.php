<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	
	class UserController extends Controller
	{
		/**
		 * Show user dashboard.
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function dashboard()
		{
			if (!auth()->check())
				return redirect()->route('login');
			
			return view('dashboard');
		}
	}
