<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Statement extends Model
{
    protected $table = 'statements';

    protected $fillable = ['statement_number', 'statement_final_amount', 'statement_final_letter_number', 'statement_final_letter_date', 'contract_id ','_period_operation_start' ,'physical_progress_percentage','_period_operation_end','consultant_approved_amount','statement_last_amount','statement_next_amount'];

    public $timestamps = false;

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
