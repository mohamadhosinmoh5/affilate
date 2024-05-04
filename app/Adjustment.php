<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Adjustment extends Model
{
    protected $table = 'adjustments';
    protected $fillable = ['statement_adjustment_number', 'statement_adjustment_number_final_amount', 'statement_adjustment_number_final_letter_number', 'statement_adjustment_number_final_letter_date', 'contract_id'];

    public $timestamps = false;
    
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
    
}
