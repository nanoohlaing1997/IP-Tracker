<?php

namespace App\Http\Controllers;

use App\Contracts\AuthOTPModuleInterface;
use App\Contracts\UserModuleInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userModule;

    protected $authOTP;

    public function __construct(UserModuleInterface $userModule, AuthOTPModuleInterface $authOTP)
    {
        $this->userModule = $userModule;

        $this->authOTP = $authOTP;

        $this->middleware('auth:api', ['except' => ['login', 'register']]);
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
            return response()->json(
                [
                    'data' => [
                        'message' => 'register complete',
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

    public function login(Request $request)
    {
        $validatedData = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );
        $token = Auth::attempt($validatedData);

        if ($token) {
            $OTP = $this->authOTP->createOTP($validatedData['email']);

            return response()->json(
                [
                    'data' => [
                        'message' => 'login success',
                        'access_token' => $token,
                        'token_type' => 'Bearer Token',
                        'expires_in' => config('jwt.ttl').' minutes',
                    ],
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
                'new_password' => 'required',
            ]
        );
        $authUser = Auth::user();
        if ($authUser) {
            $user = $this->userModule->findUserByEmail($authUser->email);
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
                'message' => 'Auth user not found, please insert token',
            ],
            404
        );
    }
}
