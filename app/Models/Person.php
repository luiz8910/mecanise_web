<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Person.
 *
 * @package namespace App\Models;
 */
class Person extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'cpf', 'dateBirth', 'cel', 'cel2', 'gender', 'description', 'workshop_id',
        'zip_code', 'street', 'number', 'district', 'city', 'state',
        'address_reference', 'img_profile', 'cpf', 'role_id'
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function role()
    {
        return $this->hasOne(Roles::class);
    }

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }

}
