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
			
			$user = auth()->user();
			
			if ($user->type == 0)
				return view('user.dashboard', compact('user'));
			elseif ($user->type == 1)
				return view('investigator.dashboard', compact('user'));
			elseif ($user->type == 2)
				return view('administrator.dashboard', compact('user'));
			else
				return response("No dashboard available for this user.", 404);
		}
	}
