<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthenticationService
{
    /**
     * check user phone or email is verified
     *
     * @param \App\Models\User $user
     * @param $data
     *
     * @return array|null
     */
    // public static function checkVerification(User $user, $data)
    // {
    //     if (is_null($user->email_verified_at)) {
    //         Log::info('Registration failed with err code ' . 1003, [$data]);
    //         return [
    //             'message' =>  'Anda belum verifikasi email',
    //             'code' => 1003,
    //             'data' => $data,
    //         ];
    //     } else {
    //         return null;
    //     }
    // }


    /**
     * login action by email and password
     *
     * @param array $request
     *
     * @return array
     */
    public function login(array $request)
    {
        try {
            if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
                throw new Exception('Email atau password Anda tidak cocok');
            }

            // if (!auth()->user()->hasRole('reseller')) {
            //     Auth::logout();
            //     throw new Exception('Akun Anda bukan reseller');
            // }

            $user = User::whereId(auth()->id())->firstOrFail();
            // return $user;
            $token = $user->createToken('authToken')->accessToken;

            return [
                'token' => $token,
                'user' => $user,
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }


    public function register(array $param)
    {
        try {
            $user = User::create([
                'name' => $param['name'],
                'email' => $param['email'],
                'password' => bcrypt($param['password'])
            ]);

            // Create Passport token
            $token = $user->createToken('authToken')->accessToken;
            Log::info('New token generated: ' . $token);

            return [
                'token' => $token,
                'user' => $user,
            ];
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function logout($user)
    {
        $token = $user->token();
        $token->revoke();
    }
}
