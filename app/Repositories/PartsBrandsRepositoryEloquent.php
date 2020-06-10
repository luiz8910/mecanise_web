<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Parts_BrandsRepository;
use App\Models\PartsBrands;
use App\Validators\PartsBrandsValidator;

/**
 * Class PartsBrandsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PartsBrandsRepositoryEloquent extends BaseRepository implements PartsBrandsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PartsBrands::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
