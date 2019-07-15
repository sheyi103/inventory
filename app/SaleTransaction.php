<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Customer;
use App\BankAccount;
use App\MobileBanking;

class SaleTransaction extends Model
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }

    public function account()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id')->withTrashed();
    }

    public function mobileBanking()
    {
        return $this->belongsTo(MobileBanking::class, 'mobile_banking_id');
    }
}
