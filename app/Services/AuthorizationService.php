<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Service;
use App\Entities\Authorization;

class AuthorizationService extends Service
{
    public function getToken(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator->errors()->toArray());
        }

        $credentials = $request->only('email', 'password');

        if (! $token = \Auth::attempt($credentials)) {
            $this->response->errorUnauthorized(trans('auth.incorrect'));
        }

        $authorization = new Authorization($token);
        return response()->json($authorization->toArray());
    }

    public function refreshToken()
    {
        $authorization = new Authorization(\Auth::refresh());
        return response()->json($authorization->toArray());
    }

    public function logout()
    {
        \Auth::logout();
        return $this->response->noContent();
    }
}