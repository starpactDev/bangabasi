<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ShiprocketAuthService
{
    protected $email;
    protected $password;

    public function __construct()
    {
        $this->email = env('SHIPROCKET_EMAIL');
        $this->password = env('SHIPROCKET_PASSWORD');
    }

    public function getToken()
    {
        // Check if token exists in cache
        if (Cache::has('shiprocket_token')) {
            return Cache::get('shiprocket_token');
        }

        // If not, authenticate and store it
        return $this->authenticate();
    }

    public function authenticate()
    {
        $response = Http::post(env('SHIPROCKET_API_BASE_URL') . '/auth/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $token = $data['token'];

            // Store token in cache for 9 days (Shiprocket expires in 10 days)
            Cache::put('shiprocket_token', $token, now()->addDays(9));

            return $token;
        }

        return null;
    }
}
