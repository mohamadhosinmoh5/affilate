<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Deposit extends Model
{
    protected $table = 'deposits';

    protected $fillable = ['advance_deposit_release_letter_number', 'release_date', 'number_letter_release_guarantee_performance_obligations', 'number_release_letter_deposit_good_work', 'number_release_letter_deposit_good_work_final', 'letter_date', 'contract_id '];

    public $timestamps = false;


    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
