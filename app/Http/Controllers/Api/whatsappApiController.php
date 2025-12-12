<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\WhatsappSession;
use App\Models\WhatsappSessionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class whatsappApiController extends Controller
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

    public function SessionInformation(Request $request)
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

    public function SessionStart(Request $request)
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

    public function SessionStop(Request $request)
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

    public function SessionLogout(Request $request)
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

    public function SessionRestart(Request $request)
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

    public function SessionAuthQrCode(Request $request)
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



    /**
     * Send text message via WhatsApp
     */
    public function ChatSendText(Request $request)
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

            $validator = Validator::make($request->all(), [
                'chatId' => 'required|string',
                'message' => 'required|string',
            ]);


            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            // Implement sending text message logic here
            $response = $this->wahaRequest('POST', '/api/sendText', [
                "chatId" => $request->input('chatId'),
                "reply_to" => null,
                "linkPreview" => true,
                "linkPreviewHighQuality" => false,
                "message" => $request->input('message'),
                "session" => $team->name_id,
            ]);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Text message sent successfully',
                    'data' => [
                        'team' => $team,
                        'response' => $response->json() ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to send text message', 'data' => null], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Send image message via WhatsApp
     */
    public function ChatSendImage(Request $request)
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

            $validator = Validator::make($request->all(), [
                'chatId' => 'required|string',
                'image' => 'required|string', // URL or base64
                'caption' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            $data = [
                "chatId" => $request->input('chatId'),
                "session" => $team->name_id,
            ];

            // Check if image is URL or base64
            $image = $request->input('image');
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                $data['file'] = [
                    'url' => $image
                ];
            } else {
                $data['file'] = [
                    'data' => $image,
                    'mimetype' => $request->input('mimetype', 'image/jpeg'),
                    'filename' => $request->input('filename', 'image.jpg')
                ];
            }

            if ($request->has('caption')) {
                $data['caption'] = $request->input('caption');
            }

            $response = $this->wahaRequest('POST', '/api/sendImage', $data);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Image message sent successfully',
                    'data' => [
                        'team' => $team,
                        'response' => $response->json() ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to send image message', 'data' => $response->json()], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Send document/file via WhatsApp
     */
    public function ChatSendDocument(Request $request)
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

            $validator = Validator::make($request->all(), [
                'chatId' => 'required|string',
                'document' => 'required|string', // URL or base64
                'filename' => 'required|string',
                'caption' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            $data = [
                "chatId" => $request->input('chatId'),
                "session" => $team->name_id,
            ];

            // Check if document is URL or base64
            $document = $request->input('document');
            if (filter_var($document, FILTER_VALIDATE_URL)) {
                $data['file'] = [
                    'url' => $document,
                    'filename' => $request->input('filename')
                ];
            } else {
                $data['file'] = [
                    'data' => $document,
                    'mimetype' => $request->input('mimetype', 'application/octet-stream'),
                    'filename' => $request->input('filename')
                ];
            }

            if ($request->has('caption')) {
                $data['caption'] = $request->input('caption');
            }

            $response = $this->wahaRequest('POST', '/api/sendFile', $data);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Document sent successfully',
                    'data' => [
                        'team' => $team,
                        'response' => $response->json() ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to send document', 'data' => $response->json()], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Send voice message via WhatsApp
     */
    public function ChatSendVoice(Request $request)
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

            $validator = Validator::make($request->all(), [
                'chatId' => 'required|string',
                'voice' => 'required|string', // URL or base64
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            $data = [
                "chatId" => $request->input('chatId'),
                "session" => $team->name_id,
            ];

            // Check if voice is URL or base64
            $voice = $request->input('voice');
            if (filter_var($voice, FILTER_VALIDATE_URL)) {
                $data['file'] = [
                    'url' => $voice
                ];
            } else {
                $data['file'] = [
                    'data' => $voice,
                    'mimetype' => $request->input('mimetype', 'audio/ogg; codecs=opus'),
                    'filename' => $request->input('filename', 'voice.ogg')
                ];
            }

            $response = $this->wahaRequest('POST', '/api/sendVoice', $data);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Voice message sent successfully',
                    'data' => [
                        'team' => $team,
                        'response' => $response->json() ?? null,
                    ]
                ], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to send voice message', 'data' => $response->json()], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

    /**
     * Send bulk text messages via WhatsApp
     */
    public function ChatSendBulkText(Request $request)
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

            $validator = Validator::make($request->all(), [
                'chatIds' => 'required|array|min:1',
                'chatIds.*' => 'required|string',
                'message' => 'required|string',
                'delay' => 'nullable|integer|min:0|max:60000', // delay in milliseconds
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Validation error', 'validation' => $validator->errors(), 'data' => null], 422);
            }

            $chatIds = $request->input('chatIds');
            $message = $request->input('message');
            $delay = $request->input('delay', 1000); // default 1 second delay

            $results = [];
            $successCount = 0;
            $failCount = 0;

            foreach ($chatIds as $index => $chatId) {
                // Add delay between messages (except for the first one)
                if ($index > 0 && $delay > 0) {
                    usleep($delay * 1000); // convert to microseconds
                }

                $response = $this->wahaRequest('POST', '/api/sendText', [
                    "chatId" => $chatId,
                    "reply_to" => null,
                    "linkPreview" => true,
                    "linkPreviewHighQuality" => false,
                    "message" => $message,
                    "session" => $team->name_id,
                ]);

                if ($response->successful()) {
                    $successCount++;
                    $results[] = [
                        'chatId' => $chatId,
                        'status' => 'success',
                        'response' => $response->json() ?? null,
                    ];
                } else {
                    $failCount++;
                    $results[] = [
                        'chatId' => $chatId,
                        'status' => 'failed',
                        'error' => $response->json()['message'] ?? 'Unknown error',
                    ];
                }
            }

            return response()->json([
                'status' => $failCount === 0 ? 'success' : ($successCount > 0 ? 'partial' : 'error'),
                'message' => "Bulk message completed. Success: {$successCount}, Failed: {$failCount}",
                'data' => [
                    'team' => $team,
                    'total' => count($chatIds),
                    'success_count' => $successCount,
                    'fail_count' => $failCount,
                    'results' => $results,
                ]
            ], $failCount === 0 ? 200 : ($successCount > 0 ? 207 : 500));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
