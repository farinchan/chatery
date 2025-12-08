<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ObservabilityController extends Controller
{
    public function ping()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/ping');

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Pong from WAHA API', 'data' => $response->json()], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to ping WAHA API', 'data' => null], 500);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $th->getMessage(), 'data' => null], 500);
        }
    }

    public function healthCheck()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/health');

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'WAHA API is healthy', 'data' => $response->json()], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'WAHA API health check failed', 'data' => null], 500);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $th->getMessage(), 'data' => null], 500);
        }
    }

    public function serverStatus()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get(env('WAHA_API_URL') . '/api/server/status');

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'WAHA API server status fetched successfully', 'data' => $response->json()], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to fetch WAHA API server status', 'data' => null], 500);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $th->getMessage(), 'data' => null], 500);
        }
    }
}
