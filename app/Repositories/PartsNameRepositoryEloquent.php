<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Parts_NameRepository;
use App\Models\PartsName;
use App\Validators\PartsNameValidator;

/**
 * Class PartsNameRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PartsNameRepositoryEloquent extends BaseRepository implements PartsNameRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PartsName::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
