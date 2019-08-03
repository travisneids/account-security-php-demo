<?php

namespace App\Http\Controllers\Api;

use Authy\AuthyApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthyController extends Controller
{
    /**
     * @param Request  $request
     * @param AuthyApi $authyApi
     * @return JsonResponse
     */
    public function sms(Request $request, AuthyApi $authyApi)
    {
        if (!$request->session()->has('user')) {
            Log::error('User session not found');
            return response()->json(['error' => 'User session not found']);
        }

        $user     = $request->session()->get('user');
        $response = $authyApi->requestSms($user->authy_id, ['force' => 'true']);

        if (!$response->ok()) {
            Log::error('Error sending SMS');
            return response()->json(['error' => 'Error sending SMS']);
        }

        return response()->json($response->ok(), 200);
    }

    /**
     * @param Request  $request
     * @param AuthyApi $authyApi
     * @return JsonResponse
     */
    public function voice(Request $request, AuthyApi $authyApi)
    {
        if (!$request->session()->has('user')) {
            Log::error('User session not found');
            return response()->json(['error' => 'User session not found']);
        }

        $user     = $request->session()->get('user');
        $response = $authyApi->phoneCall($user->authy_id, ['force' => 'true']);

        if (!$response->ok()) {
            Log::error('Error sending Voice');
            return response()->json(['error' => 'Error sending Voice']);
        }

        return response()->json($response->ok(), 200);
    }

    /**
     * @param Request  $request
     * @param AuthyApi $authyApi
     * @return JsonResponse
     */
    public function createOneTouch(Request $request, AuthyApi $authyApi)
    {
        if (!$request->session()->has('user')) {
            Log::error('User session not found');
            return response()->json(['error' => 'Verify-Authy-Token-Error']);
        }

        $user     = $request->session()->get('user');
        $message  = 'Customize this push notification with your messaging';
        $response = $authyApi->createApprovalRequest($user->authy_id, $message);

        if (!$response->ok()) {
            Log::error('Error sending One Touch');
            return response()->json(['error' => 'Error sending One Touch']);
        }

        $request->session()->put('uuid', $response->bodyvar('approval_request'));

        return response()->json(['uuid' => $response->bodyvar('approval_request')], 200);
    }

    /**
     * @param Request  $request
     * @param AuthyApi $authyApi
     * @return JsonResponse
     */
    public function verifyOneTouch(Request $request, AuthyApi $authyApi)
    {
        if (!$request->session()->has('uuid')) {
            Log::error('UUID session not found');
            return response()->json(['error' => 'UUID missing from session']);
        }

        $response = $authyApi->getApprovalRequest($request->session()->get('uuid')->uuid);

        if (!$response->ok()) {
            Log::error('Error checking One Touch');
            return response()->json(['error' => 'Error checking One Touch']);
        }

        $approvalStatus = $response->bodyvar('approval_request')->status;

        //data.approval_request.status

        if ($approvalStatus == 'approved') {
            Log::info('OneTouch status response: ', ['status' => $approvalStatus]);
            $request->session()->put('authy', true);
        }

        return response()->json(['status' => $approvalStatus], 200);
    }

    /**
     * @param Request  $request
     * @param AuthyApi $authyApi
     * @return JsonResponse
     */
    public function verifyToken(Request $request, AuthyApi $authyApi)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!$request->session()->has('user')) {
            Log::error('User session not found');
            return response()->json(['error' => 'Verify-Authy-Token-Error']);
        }

        $user     = $request->session()->get('user');
        $response = $authyApi->verifyToken($user->authy_id, $request->get('token'));

        if (!$response->ok()) {
            Log::error('Verify-Authy-Token-Error' . $response->message());
            return response()->json(['error' => $response->message()], 500);
        }

        Log::info('Verify Token Response: ' . $response->message());
        return response()->json(['message' => $response->message()], 200);
    }
}
