<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DiagnosisRepository;
use App\Models\Diagnosis;
use App\Validators\DiagnosisValidator;

/**
 * Class DiagnosisRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DiagnosisRepositoryEloquent extends BaseRepository implements DiagnosisRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Diagnosis::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
