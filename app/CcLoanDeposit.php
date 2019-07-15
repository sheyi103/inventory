<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CcLoan;

class CcLoanDeposit extends Model
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
    protected $dates = ['deleted_at','deposit_date','withdraw_date'];

    public function loan(){
    	return $this->belongsTo(CcLoan::class, 'loan_id')->withTrashed();
    }
}
