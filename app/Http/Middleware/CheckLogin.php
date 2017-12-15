<?php

namespace app\Http\Middleware;

use Auth;
use Closure;
use DB;

class CheckLogin {

	public function handle($request, Closure $next){
		// if(!Auth::check()){
		// 	return redirect('/Admin');
		// // }
		$gen = DB::table('settings_general')->get();
       	if (count($gen) == 0) {
       		return redirect('/Site-Setup');
       	}
		return $next($request);
	}
}