<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CarBrandsRepository;
use App\Models\CarBrands;
use App\Validators\CarBrandsValidator;

/**
 * Class CarBrandsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CarBrandsRepositoryEloquent extends BaseRepository implements CarBrandsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CarBrands::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
