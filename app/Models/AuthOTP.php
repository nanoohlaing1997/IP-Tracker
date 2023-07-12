<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\AuthOTPModelInterface;

class AuthOTP extends Model implements AuthOTPModelInterface
{
	protected $connection = 'mysql';

	protected $table = 'auth_otps';

	protected $fillable = [
		'email',
		'otp_code',
		'expired_at',
	];
}