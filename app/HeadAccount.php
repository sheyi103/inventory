<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Account;

class HeadAccount extends Model
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

    public function accountType()
    {
        return $this->belongsTo('App\AccountType')->withTrashed();
    }

    public function accounts() {
        return $this->hasMany(Account::class);
    }
}
