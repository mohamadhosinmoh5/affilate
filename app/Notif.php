<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Notif extends Model
{
    protected $table = 'notifs';

    protected $fillable = ['contract_id', 'title', 'read','day_avg', 'end_date','day_last'];


    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
