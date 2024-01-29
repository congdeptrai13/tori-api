<?php

namespace App\Repositories\User;

use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getUserWithPaginate($page, $page_size)
    {
        return $this->_model::where("status", 1)->skip(($page - 1) * $page_size)->take($page_size)->get();;
    }
}
