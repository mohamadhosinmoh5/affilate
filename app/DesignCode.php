<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DesignCode extends Model
{
    protected $table = 'designcodes';

    protected $fillable = ['title','allocated_amount'];

    public function contract()
    {
        return $this->hasOne(Contract::class, 'contractor_id');
    }
}
