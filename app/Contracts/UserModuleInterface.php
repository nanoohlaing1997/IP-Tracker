<?php

namespace App\Contracts;

interface UserModuleInterface
{
    public function createUser(string $name, string $email, array $data): UserModelInterface;

    public function resetPassword(UserModelInterface $user, $password): bool;
}
