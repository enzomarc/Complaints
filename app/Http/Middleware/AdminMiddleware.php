<?php
	
	namespace App\Http\Middleware;
	
	use Closure;
	
	class AdminMiddleware
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \Closure $next
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{
			if (auth()->user()->type != 2) {
				auth()->logout();
				return redirect()->route('login');
			}
			
			return $next($request);
		}
	}
