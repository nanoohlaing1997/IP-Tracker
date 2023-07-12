<?php

namespace App\Modules;

use App\Contracts\AuthOTPModelInterface;
use App\Contracts\AuthOTPModuleInterface;
use Carbon\Carbon;

class AuthOTPModule implements AuthOTPModuleInterface
{
    protected $authModel;

    public function __construct(AuthOTPModelInterface $authModel)
    {
        $this->authModel = $authModel;
    }

    public function createOTP(string $email): ?AuthOTPModelInterface
    {
        $expiredAt = Carbon::now()->addMinutes(3)->toDateTimeString();
        $otp = rand(1000, 9999);

        return $this->authModel->create(
            [
                'email' => $email,
                'otp_code' => $otp,
                'expired_at' => $expiredAt,
            ]
        );
    }

    public function checkOTP(string $email, string $otpCode): bool
    {
        $validDate = Carbon::now()->toDateString();
        $validTime = Carbon::now()->toTimeString();
        $validate = $this->authModel
            ->where('email', $email)
            ->where('otp_code', $otpCode)
            ->orderByDesc('id')
            ->whereDate('expired_at', $validDate)
            ->whereTime('expired_at', '>=', $validTime)
            ->first();

        if ($validate) {
            return true;
        }

        return false;
    }
}
