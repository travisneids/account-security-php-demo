<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Twilio\Rest\Verify\V2\Service\VerificationInstance;

class VerifyController extends Controller
{
    /**
     * @var Client
     */
    private $twilioClient;

    /**
     * VerifyController constructor.
     * @param Client $twilioClient
     */
    public function __construct(Client $twilioClient)
    {
        $this->twilioClient = new $twilioClient(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'via'          => 'required',
            'locale'       => 'required',
            'country_code' => 'required',
            'phone_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $e164Number = create_e164($request->get('country_code'), $request->get('phone_number'));

        try {
            $verification = $this->createVerify($e164Number, $request->get('locale'), $request->get('via'));
            Log::info('success creating verify v2 call', $verification->toArray());
            return response()->json($verification->toArray(), 200);
        } catch (TwilioException $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function validateCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'phone_number' => 'required',
            'token'        => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $e164Number = create_e164($request->get('country_code'), $request->get('phone_number'));

        try {
            $checkVerification = $this->twilioClient->verify->v2->services(env('TWILIO_SERVICE_SID'))
                ->verificationChecks
                ->create($request->get('token'),
                    ['to' => $e164Number]);

            if(!$checkVerification->valid) {
                Log::error('Verification code invalid.');
                return response()->json(['error' => 'Verification code invalid.'], 500);
            }

            Log::info('Confirm phone success confirming code: ', $checkVerification->toArray());
            return response()->json(['status' => 'success'], 200);
        } catch (TwilioException $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param $e164PhoneNumber
     * @param $locale
     * @param $via
     * @return VerificationInstance
     * @throws TwilioException
     */
    private function createVerify($e164PhoneNumber, $locale, $via)
    {
        return $this->twilioClient->verify->v2
            ->services(env('TWILIO_SERVICE_SID'))
            ->verifications
            ->create($e164PhoneNumber, $via, ['locale' => $locale]);
    }
}
