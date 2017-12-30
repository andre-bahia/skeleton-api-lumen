<?php
/**
 * Created by PhpStorm.
 * User: andreluis
 * Date: 28/12/17
 * Time: 13:46
 */

namespace App\Services;


use App\Repositories\UserRepositoryEloquent;

class UserService
{
    /** @var UserRepositoryEloquent $repository */
    private $repository;

    public function __construct(UserRepositoryEloquent $repositoryEloquent)
    {
        $this->repository = $repositoryEloquent;
    }

    public function getAll()
    {
        return $this->repository->paginate(10, ['*']);
    }

}