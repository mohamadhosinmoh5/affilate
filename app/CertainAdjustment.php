<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CertainAdjustment extends Model
{
    protected $table = 'certain_adjustments';
    protected $fillable = ['final_adjustment_amount', 'adjustment_amount_letter_number', 'adjustment_amount_letter_date	', 'contract_id'];

    public $timestamps = false;

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
    
}
