<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WorkshopRepository;
use App\Models\Workshop;
use App\Validators\WorkshopValidator;

/**
 * Class WorkshopRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WorkshopRepositoryEloquent extends BaseRepository implements WorkshopRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Workshop::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
