<?php
namespace App\Services;

use App\Repositories\UserRepositoryEloquent;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService extends Service
{
    /** @var UserRepositoryEloquent $repository */
    private $repository;

    public function __construct(UserRepositoryEloquent $repositoryEloquent)
    {
        $this->repository = $repositoryEloquent;
    }

    public function all()
    {
        try {
            $data = $this->repository->paginate(10, ['*']);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode);
        }
    }

    public function store($request)
    {
        try {
            $attributes = [
                'name'      => $request['name'],
                'email'     => $request['email'],
                'phone'     => $request['phone'],
                'password'  => app('hash')->make($request['password']),
                'active'    => $request['active']
            ];

            $user = $this->repository->create($attributes);
            return $this->response->array($user->toArray());
        } catch (QueryException $e){
            throw new StoreResourceFailedException("Email already registered");
        } catch(ValidatorException $validator) {
            $this->errorBadRequest($validator->getMessageBag()->getMessages());
        }
    }

    public function update(Request $request, int $id)
    {

    }

    public function destroy(int $id)
    {
        $data = $this->repository->delete($id);
        return $this->success($data);
    }

    public function findById(int $id)
    {
        try {
            $data = $this->repository->find($id);
            return $this->success($data);
        } catch (QueryException $e) {
            return $this->response->errorNotFound('User not found');    
        }
    }
}