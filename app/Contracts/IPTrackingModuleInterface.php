<?php

namespace App\Contracts;

interface IPTrackingModuleInterface
{
    public function createTracker(UserModelInterface $user, array $data): IPTrackingModelInterface;
}
