<?php

namespace App\Http\Controllers\Api;

use Authy\AuthyApi;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * @param Request  $request
     * @param AuthyApi $authyApi
     * @return JsonResponse
     */
    public function request(Request $request, AuthyApi $authyApi)
    {
        $validator = Validator::make($request->all(), [
            'username'     => 'required|unique:users',
            'password'     => 'required',
            'email'        => 'required|email',
            'country_code' => 'required',
            'phone_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($request->all());

        try {
            $authyUser      = $authyApi->registerUser($user->email, $user->phone_number, $user->country_code);
            $user->authy_id = $authyUser->id();
            $user->save();

            Log::info('User registered successfully', $user->toArray());
            return response()->json([], 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
