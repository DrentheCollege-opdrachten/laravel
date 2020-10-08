<?php

namespace App\Http\Middleware;

use App\Models\Band;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InBand
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $bandId = $request->route()->parameters["bandId"];
        $isMember = Auth::user()->getBands()->where('band_id', '=', $bandId)->count() > 0 ;
            if (!$isMember) {
                abort(403, 'acces denied. you are not a member of this band');
            }

        return $next($request);
    }
}
