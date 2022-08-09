<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;

class UserSearchController extends ApiController
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
            if ($user->count() == 0)
                return $this->sendError('Data Not Found', Response::HTTP_NO_CONTENT);
            // $message = $user->count() == 0 ? "User Not Found" : "Success Found Data";

            return $this->sendSuccess($user, 'Success Found Data');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
