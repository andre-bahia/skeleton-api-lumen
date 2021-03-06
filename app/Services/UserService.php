<?php
namespace App\Services;

use App\Repositories\UserRepositoryEloquent;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            $attributes = [
                'name'   => $request->get('name'),
                'email'  => $request->get('email'),
                'phone'  => $request->get('phone'),
                'active' => $request->get('active'),

            ];
            
            $user = $this->repository->update($attributes, $id);
            return $this->success($user->toArray());
        
        } catch(ValidatorException $validator) {
            $this->errorBadRequest($validator->getMessageBag()->getMessages());
        }

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
        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound('User not found');    
        }
    }
}