<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ResponseApi;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;


class ApiController extends Controller
{
    use ResponseApi;
}
