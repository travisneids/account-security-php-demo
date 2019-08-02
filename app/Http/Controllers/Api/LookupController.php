<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LookupController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'phone_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(json_decode($validator), 400);
        }

        $fullPhone = create_e164($request->get('country_code'), $request->get('phone_number'));

        $http     = new Client;
        $response = $http->get('https://lookups.twilio.com/v1/PhoneNumbers/' . $fullPhone . '?Type=carrier',
            ['auth' => [env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN')]]);

        $responseJson = json_decode($response->getBody(), true);

        Log::info('Successful Lookup Response:', $responseJson);

        return response()->json($responseJson);
    }
}
