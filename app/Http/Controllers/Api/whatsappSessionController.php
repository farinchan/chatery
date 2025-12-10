<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\WhatsappSession;
use App\Models\WhatsappSessionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class whatsappSessionController extends Controller
{
    /**
     * Get team by auth token
     */
    private function getTeamByToken(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return null;
        }

        return Team::whereHas('teamUsers', function ($query) use ($token) {
            $query->where('token', $token);
        })->first();
    }

    /**
     * Make WAHA API request
     */
    private function wahaRequest(string $method, string $endpoint, array $data = [])
    {
        $http = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => env('WAHA_API_KEY'),
            'Content-Type' => 'application/json',
        ]);

        if ($method === 'GET') {
            return $http->get(env('WAHA_API_URL') . $endpoint);
        } elseif ($method === 'POST') {
            return $http->post(env('WAHA_API_URL') . $endpoint, $data);
        }

        return null;
    }

    public function index()
    {
        //
    }

    public function information(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $response = $this->wahaRequest('GET', '/api/sessions/' . $team->name_id);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Whatsapp Session information fetched successfully',
                    'data' => [
                        'team' => $team,
                        'status' => $response->json()['status'],
                        'me' => $response->json()['me'] ?? null,
                    ]
                ], 200);
            } else {
                if ($response->status() == 404 && isset($response->json()['message']) && $response->json()['message'] == 'Session not found') {
                    $response_create = $this->wahaRequest('POST', '/api/sessions/', [
                        "name" => $team->name_id,
                        "config" => [
                            "webhooks" => [],
                            "metadata" => [
                                "team_id" => (string) $team->id,
                                "team_name_id" => (string) $team->name_id,
                                "created_at" => (string) now()->toDateTimeString()
                            ]
                        ]
                    ]);
                    if ($response_create->successful()) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Whatsapp Session created successfully',
                            'data' => [
                                'team' => $team,
                                'status' => $response_create->json()['status'],
                                'me' => $response_create->json()['me'] ?? null,
                            ]
                        ], 200);
                    }
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to fetch session information', 'data' => null], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function start(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $response = $this->wahaRequest('POST', '/api/sessions/' . $team->name_id . '/start');

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Session started successfully',
                    'data' => [
                        'team' => $team,
                        'status' => $response->json()['status'],
                        'me' => $response->json()['me'] ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to start session', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function stop(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $response = $this->wahaRequest('POST', '/api/sessions/' . $team->name_id . '/stop');

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Session stopped successfully',
                    'data' => [
                        'team' => $team,
                        'status' => $response->json()['status'],
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to stop session', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $response = $this->wahaRequest('POST', '/api/sessions/' . $team->name_id . '/logout');

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Session logged out successfully',
                    'data' => [
                        'team' => $team,
                        'status' => $response->json()['status'],
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to log out session', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function restart(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $response = $this->wahaRequest('POST', '/api/sessions/' . $team->name_id . '/restart');

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Session restarted successfully',
                    'data' => [
                        'team' => $team,
                        'status' => $response->json()['status'],
                        'me' => $response->json()['me'] ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to restart session', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    public function authQrCode(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'X-Auth-Token header is required', 'data' => null], 400);
        }

        try {
            $team = $this->getTeamByToken($request);

            if (!$team) {
                return response()->json(['status' => 'error', 'message' => 'Team not found or invalid token', 'data' => null], 404);
            }

            $response = $this->wahaRequest('GET', '/api/' . $team->name_id . '/auth/qr');

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'QR Code fetched successfully',
                    'data' => [
                        'team' => $team,
                        'qr_code' => $response->json() ?? null,
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
