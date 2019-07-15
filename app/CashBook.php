<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Expense;
use App\SaleTransaction;
use App\PurchaseTransaction;

class CashBook extends Model
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
    protected $dates = ['deleted_at','date'];

    public function sale()
    {
        return $this->belongsTo(SaleTransaction::class, 'sale_transaction_id')->withTrashed();
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseTransaction::class, 'purchase_transaction_id')->withTrashed();
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_transaction_id')->withTrashed();
    }
}
