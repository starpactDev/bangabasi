<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShiprocketAPI
{
    protected $authService;

    public function __construct(ShiprocketAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function request($method, $endpoint, $data = [])
    {
        $token = $this->authService->getToken();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->$method(env('SHIPROCKET_API_BASE_URL') . $endpoint, $data);

        // If token expires, re-authenticate and retry once
        if ($response->status() == 401) {
            $token = $this->authService->authenticate();

            return Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->$method(env('SHIPROCKET_API_BASE_URL') . $endpoint, $data);
        }

        return $response;
    }
}
