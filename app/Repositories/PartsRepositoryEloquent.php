<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PartsRepository;
use App\Models\Parts;
use App\Validators\PartsValidator;

/**
 * Class PartsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PartsRepositoryEloquent extends BaseRepository implements PartsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Parts::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
