<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DeliveryTermination extends Model
{
    protected $table = 'delivery_terminations';

    protected $fillable = ['notification_46_48', 'contract_termination_number', 'contract_termination_date', 'provisional_delivery_date', 'number_notification_temporary_delivery', 'contract_id', 'minutes_date', 'minutes_number', 'definite_delivery_date', 'Confirmation_delivery_letter_number'];

    public $timestamps = false;

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
