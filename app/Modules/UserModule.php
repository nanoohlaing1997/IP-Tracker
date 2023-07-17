<?php

namespace App\Modules;

use App\Contracts\UserModelInterface;
use App\Contracts\UserModuleInterface;
use Illuminate\Support\Facades\Hash;

class UserModule implements UserModuleInterface
{
    protected $user;

    public function __construct(UserModelInterface $user)
    {
        $this->user = $user;
    }

    public function createUser(string $name, string $email, array $data): UserModelInterface
    {
        return $this->user->create([
            'name' => $name,
            'email' => $email,
            'email_verified_at' => $data['email_verified_at'] ?? null,
            'password' => Hash::make($data['password']),
            'remember_token' => $data['remember_token'] ?? null,
        ]);
    }

    public function findUserByEmail(string $email): UserModelInterface
    {
        return $this->user->where('email', $email)->first();
    }

    public function resetPassword(UserModelInterface $user, $password): bool
    {
        $user->password = $password;
        $user->save();

        return true;
    }
}
