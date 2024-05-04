<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Contractor extends Model
{
    protected $table = 'contractors';

    protected $fillable = ['name', 'adress', 'melli_code', 'registration_number', 'connector_name', 'connector_phone' ];
    public $timestamps = false;

    public function contract()
    {
        return $this->hasOne(Contract::class, 'contractor_id');
    }
}
