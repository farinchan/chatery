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
        $session_token = $request->header('session_token');
        if (!$session_token) {
            return response()->json(['error' => 'Token header is required'], 400);
        }

        try {
            $whatsappSession = WhatsappSession::whereHas('whatsapp_session_users', function ($query) use ($session_token, $session_name) {
                $query->where('session_token', $session_token);
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

    public function information(Request $request, $session_name)
    {

        $session_token = $request->header('session_token');
        if (!$session_token) {
            return response()->json(['error' => 'Token header is required'], 400);
        }
        try {
            $whatsappSession = WhatsappSession::whereHas('whatsapp_session_users', function ($query) use ($session_token) {
                $query->where('session_token', $session_token);
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
                return response()->json(['status' => 'success', 'message' => 'Session information fetched successfully', 'data' => [
                    'session' => $whatsappSession,
                    'status' => $response->json()['status'],
                    "me" => $response->json()['me'] ?? null,
                ]], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to fetch session information', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function start(Request $request, $session_name)
    {
        $session_token = $request->header('session_token');
        if (!$session_token) {
            return response()->json(['error' => 'Token header is required'], 400);
        }

        try {
            $whatsappSession = WhatsappSession::whereHas('whatsapp_session_users', function ($query) use ($session_token) {
                $query->where('session_token', $session_token);
            })->with('whatsapp_session_users')->first();

            if (!$whatsappSession) {
                return response()->json(['status' => 'error', 'message' => 'Session not found or invalid token', 'data' => null], 404);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/api/sessions/' . $whatsappSession->session_name . '/start');

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Session started successfully',
                    'data' => [
                        'session' => $whatsappSession,
                        'status' => $response->json()['status'],
                        "me" => $response->json()['me'] ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to start session', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function stop(Request $request, $session_name)
    {
        $session_token = $request->header('session_token');
        if (!$session_token) {
            return response()->json(['error' => 'Token header is required'], 400);
        }

        try {
            $whatsappSession = WhatsappSession::whereHas('whatsapp_session_users', function ($query) use ($session_token) {
                $query->where('session_token', $session_token);
            })->with('whatsapp_session_users')->first();

            if (!$whatsappSession) {
                return response()->json(['status' => 'error', 'message' => 'Session not found or invalid token', 'data' => null], 404);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/api/sessions/' . $whatsappSession->session_name . '/stop');

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Session stopped successfully', 'data' => [
                    'session' => $whatsappSession,
                    'status' => $response->json()['status'],
                ]], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to stop session', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function logout(Request $request, $session_name)
    {
        $session_token = $request->header('session_token');
        if (!$session_token) {
            return response()->json(['error' => 'Token header is required'], 400);
        }

        try {
            $whatsappSession = WhatsappSession::whereHas('whatsapp_session_users', function ($query) use ($session_token) {
                $query->where('session_token', $session_token);
            })->with('whatsapp_session_users')->first();

            if (!$whatsappSession) {
                return response()->json(['status' => 'error', 'message' => 'Session not found or invalid token', 'data' => null], 404);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/api/sessions/' . $whatsappSession->session_name . '/logout');

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Session logged out successfully', 'data' => [
                    'session' => $whatsappSession,
                    'status' => $response->json()['status'],
                ]], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to log out session', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function restart(Request $request, $session_name)
    {
        $session_token = $request->header('session_token');
        if (!$session_token) {
            return response()->json(['error' => 'Token header is required'], 400);
        }

        try {
            $whatsappSession = WhatsappSession::whereHas('whatsapp_session_users', function ($query) use ($session_token) {
                $query->where('session_token', $session_token);
            })->with('whatsapp_session_users')->first();

            if (!$whatsappSession) {
                return response()->json(['status' => 'error', 'message' => 'Session not found or invalid token', 'data' => null], 404);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/api/sessions/' . $whatsappSession->session_name . '/restart');

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Session restarted successfully',
                    'data' => [
                        'session' => $whatsappSession,
                        'status' => $response->json()['status'],
                        "me" => $response->json()['me'] ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to restart session', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function AuthQrCode(Request $request, $session_name)
    {
        $session_token = $request->header('session_token');
        if (!$session_token) {
            return response()->json(['error' => 'Token header is required'], 400);
        }

        try {
            $whatsappSession = WhatsappSession::whereHas('whatsapp_session_users', function ($query) use ($session_token) {
                $query->where('session_token', $session_token);
            })->with('whatsapp_session_users')->first();

            if (!$whatsappSession) {
                return response()->json(['status' => 'error', 'message' => 'Session not found or invalid token', 'data' => null], 404);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/api/sessions/' . $whatsappSession->session_name . '/auth/qr');

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'QR Code fetched successfully',
                    'data' => [
                        'session' => $whatsappSession,
                        'qr_code' => $response->json()['qr_code'] ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to fetch QR Code', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
