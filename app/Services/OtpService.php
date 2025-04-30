<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OtpService
{
    public function sendOtp(string $mobile, array $params = [])
    {
        $mobile = '91' . $mobile; 
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',

        ])->post('https://control.msg91.com/api/v5/otp', [
            'mobile' => $mobile,
            'authkey' => config('services.msg91.auth_key'),
            'template_id' => config('services.msg91.template_id'),
            'otp_expiry' => config('services.msg91.otp_expiry'),
            ...$params // Your dynamic template params
        ]);

        return $response->json();
    }
}