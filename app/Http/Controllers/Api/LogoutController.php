<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function request(Request $request)
    {
        $request->session()->forget('user');

        return response()->json([], 200);
    }
}
