<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
            ])->get(env('WAHA_API_URL') . '/api/sessions/' . $session);
        }

        return $next($request);
    }
}
