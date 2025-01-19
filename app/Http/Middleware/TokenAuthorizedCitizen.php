<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Citizen\Document\DocumentTokenController;
use App\Models\DocumentFolderToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TokenAuthorizedCitizen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $citizen = Auth::user()->userable;
        $token = $request->route('token');
        $token = DocumentFolderToken::with('authorized_citizens')->where('token', $token)->get();


        if($token->isNotEmpty())
        {
            $token = $token->first();
            if($token->folder->owner_id == $citizen->id)
            {
                return $next($request);
            }
            if($token->expires_at == null)
            {
                if($token->accessibility == 'restricted')
                {
                    if($token->authorized_citizens->where('id', $citizen->id)->isNotEmpty())
                    {
                        return $next($request);
                    }
                }
                else
                {
                    return $next($request);
                }
            }
            else
            {
                $expiredTime = Carbon::parse($token->expires_at);
                $notExpiresYet = Carbon::now()->lte($expiredTime);


                if($notExpiresYet)
                {
                    if($token->accessibility == 'restricted')
                    {
                        if($token->authorized_citizens->where('id', $citizen->id)->isNotEmpty())
                        {
                            return $next($request);
                        }
                    }
                    else
                    {
                        return $next($request);
                    }
                }
                else
                {
                    dd("token expired");
                    return back()->with('error', 'token expired');
                }
            }
        }
        dd("unauthorized citizen");
        return back()->with('error', 'unauthorized citizen');

    }
}
