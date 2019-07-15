<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Supplier;
use App\RawMaterial;

class Purchase extends Model
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

    public function supplier(){
    	return $this->belongsTo(Supplier::class, 'supplier_id')->withTrashed();
    }

    public function rawMaterial(){
    	return $this->belongsTo(RawMaterial::class, 'rawMaterial_id')->withTrashed();
    }
}
