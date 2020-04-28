<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FuelRepository;
use App\Models\Fuel;
use App\Validators\FuelValidator;

/**
 * Class FuelRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FuelRepositoryEloquent extends BaseRepository implements FuelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fuel::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
