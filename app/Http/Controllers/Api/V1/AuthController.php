<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\AuthorizationService;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    /** @var AuthorizationService $service */
    private $service;

    public function __construct(AuthorizationService $authorizationService)
    {
        $this->service = $authorizationService;
    }

    public function createToken(Request $request)
    {
        return $this->service->getToken($request);
    }

    public function logout()
    {
        return $this->service->logout();
    }

    public function refreshToken()
    {
        return $this->service->refreshToken();
    }
}
