<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Workshop.
 *
 * @package namespace App\Models;
 */
class Workshop extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cel', 'email', 'website', 'cnpj', 'responsible_id', 'description',
        'zip_code', 'street', 'number', 'district', 'city', 'state', 'address_reference'
    ];

    protected $dates = ['deleted_at'];

    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
