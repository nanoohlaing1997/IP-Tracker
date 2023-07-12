<?php

namespace App\Models;

use App\Contracts\IPTrackingModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IPTracking extends Model implements IPTrackingModelInterface
{
    protected $connection = 'mysql';

    protected $table = 'ip_trackings';

    protected $fillable = [
        'ip',
        'user_id',
        'city',
        'region',
        'country',
        'country_code',
        'latitude',
        'longitude',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
