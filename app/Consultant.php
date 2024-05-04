<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Consultant extends Model
{
    protected $table = 'consultants';
    protected $fillable = ['name', 'adress', 'melli_code', 'registration_number', 'connector_name', 'connector_phone'];

    public $timestamps = false;
}
