<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    /** @var UserService $service */
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->all();
    }

    public function store(Request $request)
    {
        return $this->service->store($request->all());
    }

    public function destroy(int $id)
    {
        return $this->service->destroy($id);
    }

    public function findById(int $id)
    {
        return $this->service->findById($id);
    }

}
