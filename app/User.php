<?php

namespace TestApp;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @author Adib Hanna <adibhanna@gmail.com>
 * Class User
 * @package TestApp
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'total_product_values'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = ['total_product_values' => 'float'];

    /**
     * A user may have multiple products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
