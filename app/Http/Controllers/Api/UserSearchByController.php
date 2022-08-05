<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;

class UserSearchByController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request)
    {
        try {
            $user =  $this->userService->getSearchUser($request->search);

            // $check = AuthenticationService::checkVerification($user, $user);
            // if ($check)
            //     return $this->sendError($check['message'], $check['code'], $check['data']);


            return $this->sendSuccess($user, "Success ");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
