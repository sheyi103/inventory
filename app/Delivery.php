<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function customer(){
    	return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }

    public function product(){
    	return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }
}
