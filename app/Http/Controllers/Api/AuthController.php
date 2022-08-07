<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthenticationService;
use App\Http\Controllers\Api\ApiController;

class AuthController extends ApiController //extend to response format
{
    // logic in this services
    protected $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    //end

    public function login(LoginRequest $request)
    {

        try {
            $data = $this->authenticationService->login($request->all());

            // $check = $this->authenticationService->checkVerification($data['user'], $data);
            // if ($check)
            //     return $this->sendError($check['message'], $check['code'], $check['data']);

            return $this->sendSuccess($data);
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {

        try {
            // return $request->name;
            $data = $this->authenticationService->register($request->all());

            // $check = $this->authenticationService->checkVerification($data['user'], $data);
            // if ($check)
            //     return $this->sendError($check['message'], $check['code'], $check['data']);
            return $this->sendSuccess($data);
        } catch (Throwable $e) {
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }


    public function logout(Request $request)
    {
        try {
            $this->authenticationService->logout(
                $request->user(),
            );

            return $this->sendSuccess([], 'Success Logout!');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
}
