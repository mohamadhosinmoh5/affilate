<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ContractDetail extends Model
{
    protected $table = 'contract_details';

    // protected $fillable = ['project_code','contract_subject', 'price_list', 'finance', 'water_supply', 'wastewater', 'city', 'contractor_name', 'notice_number', 'notice_date', 'agreement_coe', 'land_delivery_date', 'extension_notice_time', 'contract_id'];
    protected $fillable = ['contract_subject', 'price_list','control_system','notice_number', 'notice_date','land_delivery_date', 'contract_id'];

    public $timestamps = false;


    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
