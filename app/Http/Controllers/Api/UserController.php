<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Api\ApiController;

class UserController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $user =  $this->userService->getAllUser();

            // $check = AuthenticationService::checkVerification($user, $user);
            // if ($check)
            //     return $this->sendError($check['message'], $check['code'], $check['data']);


            return $this->sendSuccess($user, "Success ");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $user = $this->userService->addUser($request->all());
            return $this->sendSuccess($user, "Success Add New User");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $user = $this->userService->updateUser($request->all(), $user);
            return $this->sendSuccess($user, "Success Update Data User");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user = $this->userService->deleteUser($user);
            return $this->sendSuccess($user, "Success Delete Data User");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
