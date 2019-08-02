<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class VerifyController extends Controller
{
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'via'          => 'required',
            'locale'       => 'required',
            'country_code' => 'required',
            'phone_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(json_decode($validator), 400);
        }

        $http     = new Client;
        $response = $http->get('https://lookups.twilio.com/v1/PhoneNumbers/' . $request->get('country_code') . $request->get('phone_number') . '?Type=carrier',
            ['auth' => [env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN')]]);

        return response()->json(json_decode($response->getBody()));
    }
}
