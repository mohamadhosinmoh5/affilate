<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Extension extends Model
{
    protected $table = 'extensions';

    protected $fillable = ['contract_id', 'contract_end_date', 'extension_period_time', 'allowed_days'];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public $timestamps = false;
}
