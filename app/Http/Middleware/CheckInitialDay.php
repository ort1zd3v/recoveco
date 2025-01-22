<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\StartingFound;
use App\Models\User;

class CheckInitialDay
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		$actualDate = now()->toDateString();
		$existsDay = StartingFound::whereDate('initial_date', $actualDate)->exists();

		$day = StartingFound::orderBy('id', 'desc')->first();
		if(!$existsDay){
			if($day->final_date == null){
				return redirect('starting_founds/showCloseDay');
			} else{
				return redirect('starting_founds/showInitDay');
			}
		}else{
			if($day->final_date !== null){
				return redirect('starting_founds/showInitDay');

			}else {
			}
		}
        return $next($request);
    }
}
