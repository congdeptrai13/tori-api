<?php

namespace App\Repositories\Article;

use App\Repositories\EloquentRepository;

class ArticleEloquentRepository extends EloquentRepository implements ArticleRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Article::class;
    }
}
