<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SystemRepository;
use App\Models\System;
use App\Validators\SystemValidator;

/**
 * Class SystemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SystemRepositoryEloquent extends BaseRepository implements SystemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return System::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
