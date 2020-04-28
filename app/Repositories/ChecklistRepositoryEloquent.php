<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ChecklistRepository;
use App\Models\Checklist;
use App\Validators\ChecklistValidator;

/**
 * Class ChecklistRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChecklistRepositoryEloquent extends BaseRepository implements ChecklistRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Checklist::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
