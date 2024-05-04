<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IncrementAmount extends Model
{
    protected $fillable = ['status','date', 'increment_percent', 'last_amount','new_amount','increment_number'];

    public function contract()
    {
        return $this->hasOne(Contract::class, 'increment_amount_id');
    }


}
