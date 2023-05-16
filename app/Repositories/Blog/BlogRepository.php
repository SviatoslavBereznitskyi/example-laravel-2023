<?php

declare(strict_types=1);

namespace App\Repositories\Blog;

use App\Models\Blog\Blog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class BlogRepository extends BaseRepository
{
    public function model(): string
    {
        return Blog::class;
    }

    public function getBySlug(string $slug): Blog
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->where('slug', $slug)->firstOrFail();

        $this->resetModel();

        return $model;
    }

    public function apiPaginate($limit = null): LengthAwarePaginator
    {
        $this->popCriteria(RequestCriteria::class);
        $this->applyCriteria();
        $this->applyScope();

        $limit = null === $limit ? config('repository.pagination.limit', 15) : $limit;
        $model = $this->model->makeBuilder();
        $results = $model->paginate($limit);
        $this->resetModel();

        return $this->parserResult($results);
    }
}
