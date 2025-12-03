<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WhatsappSession;
use App\Models\WhatsappSessionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class whatsappSessionController extends Controller
{
    public function index()
    {
        //
    }

    public function show(Request $request, $session_name)
    {
        $session_name = $request->header('session_token');
        if (!$session_name) {
            return response()->json(['error' => 'Token header is required'], 400);
        }

        try {
            $whatsappSession = WhatsappSession::whereHas('whatsapp_session_users', function ($query) use ($session_name) {
                $query->where('session_token', $session_name);
            })->with('whatsapp_session_users')->first();

            if (!$whatsappSession) {
                return response()->json(['status' => 'error', 'message' => 'Session not found or invalid token', 'data' => null], 404);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/api/sessions/' . $whatsappSession->session_name);

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Session status fetched successfully', 'data' => $response->json()], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to fetch session status', 'data' => null], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
