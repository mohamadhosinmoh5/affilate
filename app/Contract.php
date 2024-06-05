<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Contract extends Model
{
    protected $table = 'contracts';
    protected $fillable = ['contract_number', 'contract_title', 'contract_date', 'contract_time', 'contract_first_amount', 'contract_final_amount', 'contract_end_date'];

    public $timestamps = false;

    public function contractDetail()
    {
        return $this->hasOne(ContractDetail::class, 'contract_id', 'id');
    }

}
