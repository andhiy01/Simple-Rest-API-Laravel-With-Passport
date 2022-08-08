<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CustomException extends Exception
{
    //
    public function __construct(
        protected $message,
        protected $data = [],
        protected $code = Response::HTTP_NOT_FOUND
    ) {
        return response()->json([
            'success' => false,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ], Response::HTTP_NOT_FOUND);
    }
}
