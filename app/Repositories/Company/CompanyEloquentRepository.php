<?php

namespace App\Repositories\Company;

use App\Repositories\EloquentRepository;

class CompanyEloquentRepository extends EloquentRepository implements CompanyRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Company::class;
    }
}
