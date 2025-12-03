<?php

namespace App\Http\Middleware;

use App\Models\WhatsappSessionUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class WhatsappSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session = $request->route('session');

        if ($session) {
            $whatsappSession = WhatsappSessionUser::whereHas('whatsapp_session', function ($query) use ($session) {
                $query->where('session_name', $session);
            })->where('user_id', Auth::id())->first();

            if (!$whatsappSession) {
                abort(404);
            }

            Cookie::queue('whatsapp_session', $session, 60 * 24 * 30);


            return $next($request);
        } else {
            abort(404);
        }
    }
}
