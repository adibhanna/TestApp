<?php

namespace TestApp;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Adib Hanna <adibhanna@gmail.com>
 * Class Product
 * @package TestApp
 */
class Product extends Model
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The allowed fields.
     *
     * @var array
     */
    protected $fillable = ['product', 'total_value'];

    /**
     * Casted fields.
     *
     * @var array
     */
    protected $casts = [
        'product' => 'json',
        'total_value' => 'float'
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * A product belongs to a user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
