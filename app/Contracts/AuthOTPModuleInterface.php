<?php

namespace App\Contracts;

interface AuthOTPModuleInterface
{
    public function createOTP(string $email): ?AuthOTPModelInterface;

    public function checkOTP(string $email, string $otpCode): bool;
}
