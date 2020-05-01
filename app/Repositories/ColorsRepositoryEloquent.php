<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ColorsRepository;
use App\Models\Colors;
use App\Validators\ColorsValidator;

/**
 * Class ColorsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ColorsRepositoryEloquent extends BaseRepository implements ColorsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Colors::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
