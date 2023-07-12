<?php

namespace App\Http\Controllers;

use App\Contracts\AuthOTPModuleInterface;
use App\Contracts\UserModuleInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenFactory;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    protected $userModule;

    protected $authOTP;

    public function __construct(UserModuleInterface $userModule, AuthOTPModuleInterface $authOTP)
    {
        $this->userModule = $userModule;

        $this->authOTP = $authOTP;
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        $user = $this->userModule->createUser($validatedData['name'], $validatedData['email'], ['password' => $validatedData['password']]);
        if ($user) {
            $OTP = $this->authOTP->createOTP($validatedData['email']);

            return response()->json(
                [
                    'data' => [
                        'message' => 'register complete',
                        'otp' => $OTP->otp_code,
                    ],
                ],
                201
            );
        }

        return response()->json(
            [
                'message' => 'Registration failed',
            ],
            404
        );
    }

    public function login(Request $request, TokenRepository $tokenRepository)
    {
        $input = $request->all();
        if (Auth::attempt($input)) {
            $user = Auth::user();
            $token = app(PersonalAccessTokenFactory::class)->make(
                $user->getKey(),
                'Password Grant',
                []
            )->accessToken;

            // $token = $user->createToken('Access Token', [])->token;

            $this->authOTP->createOTP($user->email);

            return response()->json(
                [
                    'data' => $token,
                ],
                200
            );
        }

        return response()->json(
            [
                'message' => 'Login failed',
            ],
            406
        );
    }

    public function checkOTP(Request $request)
    {
        $validatedData = $request->validate(
            [
                'email' => 'required|email',
                'otp_code' => 'required|integer',
            ]
        );

        if ($this->authOTP->checkOTP($validatedData['email'], $validatedData['otp_code'])) {
            return response()->json(
                [
                    'data' => 'OTP success',
                ],
                200
            );
        }

        return response()->json(
            [
                'message' => 'OTP authentication fail',
            ],
            406
        );
    }

    public function getUserDetail(Request $request)
    {
        if ($user = Auth::user()) {
            $data = [
                'name' => $user->name,
                'email' => $user->email,
            ];

            return response()->json(
                [
                    'data' => $data,
                ],
                200
            );
        }

        return response()->json(
            [
                'message' => 'Authenticated user not found',
            ],
            404
        );
    }

    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate(
            [
                'email' => 'required|email',
                'new_password' => 'required',
            ]
        );

        $user = User::where('email', $validatedData['email'])->first();
        if ($user) {
            if ($this->userModule->resetPassword($user, $validatedData['new_password'])) {
                return response()->json(
                    [
                        'data' => 'Password reset successfully',
                    ],
                    200
                );
            }

            return response()->json(
                [
                    'message' => 'Password reset fail',
                ],
                404
            );
        }

        return response()->json(
            [
                'message' => 'User not found',
            ],
            404
        );
    }
}
