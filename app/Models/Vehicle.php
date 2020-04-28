<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Vehicle.
 *
 * @package namespace App\Models;
 */
class Vehicle extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'color', 'license_plate', 'chassis', 'description', 'km', 'owner_id', 'workshop_id', 'car_id', 'year'
    ];

    protected $dates = ['deleted_at'];

    public function owner()
    {
        return $this->belongsTo(Person::class);
    }

}
