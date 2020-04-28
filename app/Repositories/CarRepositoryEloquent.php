<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CarRepository;
use App\Models\Car;
use App\Validators\CarValidator;

/**
 * Class CarRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CarRepositoryEloquent extends BaseRepository implements CarRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Car::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
