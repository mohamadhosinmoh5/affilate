<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CertainStatement extends Model
{
    protected $table = 'certain_statements';
    protected $fillable = ['percentage_final_physical_progress', 'status_statement_amount', 'status_statement_date', 'status_statement_letter_number', 'contract_id'];

    public $timestamps = false;


    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
