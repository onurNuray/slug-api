<?php

namespace App\Http\Middleware;

use App\Exceptions\Slug\SlugException;
use App\Models\Slug;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlugCheck
{

    /**
     * This middleware checks request slug belongs to the Auth user
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $slug = Slug::find($request->slug_id);

            if ($slug->user_id != Auth::user()->id) {
                throw new SlugException('Slug is invalid', 400);
            }

            return $next($request);
        } catch (Exception $e) {
            throw new SlugException('Slug is invalid', 400);
        }
    }
}
