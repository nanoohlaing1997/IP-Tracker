<?php

namespace App\Modules;

use App\Contracts\IPTrackingModelInterface;
use App\Contracts\IPTrackingModuleInterface;
use App\Contracts\UserModelInterface;

class IPTrackingModule implements IPTrackingModuleInterface
{
    protected $track;

    public function __construct(IPTrackingModelInterface $track)
    {
        $this->track = $track;
    }

    public function createTracker(UserModelInterface $user, array $data): IPTrackingModelInterface
    {
        return $this->track->create(
            [
                'user_id' => $user->id,
                'city' => $data['city'],
                'region' => $data['region'],
                'country' => $data['region'],
                'country_code' => $data['country_code'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]
        );
    }
}
