<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Parts.
 *
 * @package namespace App\Models;
 */
class Parts extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'part_id', 'universal_code', 'brand_code', 'car_id', 'brand_parts_id',
        'start_year', 'end_year', 'notes', 'system_id'
    ];

}
