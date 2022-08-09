<?php

namespace App\Traits;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

trait ResponseApi
{

    public function sendErrorValidation($validator,  $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'success' => false,
            'code'    => $code,
            'message' => $validator->errors()->first() ?? ((!config('app.debug'))
                ? __('message.error')
                : "Some error please contact admin"),
            'data'    => ['error' => $validator->errors()->getMessages()],
        ], $code);
    }

    public function sendError($message = null, $code = Response::HTTP_NOT_FOUND, $data = [])
    {
        $data = $this->pagination($data);

        return response()->json([
            'success' => false,
            'code'    => $code,
            'message' => $message ?? ((!config('app.debug'))
                ? __('message.error')
                : $this->getMessage($code)), //"Some error please contact support@tokocuan.id",
            'data'    => $data,
        ], Response::HTTP_NOT_FOUND);
    }

    protected function sendSuccess($data = [], $message = null, $code = Response::HTTP_OK)
    {
        $data = $this->pagination($data);

        return response()->json([
            'success' => true,
            'code' => $code,
            'message' => $message,
            // 'pagination' => $data['pagination'] ?? [],
            'data' => $data,
        ], $code);
    }

    protected function pagination($data)
    {
        if ($data instanceof LengthAwarePaginator) {
            $result['pagination']['total'] = $data->total();
            $result['pagination']['offset'] = $data->perPage();
            $result['pagination']['current'] = $data->currentpage();
            $result['pagination']['last'] = $data->lastPage();
            $result['pagination']['next'] = (string) $data->nextPageUrl();
            $result['pagination']['prev'] = (string) $data->previousPageUrl();
            $result['data'] = $data->all();
        } else {
            $result = $data;
        }
        return $result;
    }

    private function getMessage($statusCode)
    {
        switch ($statusCode) {
            case 401:
                $message = 'Unauthorized';
                break;
            case 403:
                $message = 'Forbidden';
                break;
            case 404:
                $message = 'Not Found';
                break;
            case 405:
                $message = 'Method Not Allowed';
                break;
            default:
                $message = 'Whoops, looks like something went wrong';
                break;
        }

        return $message;
    }
}
