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

    public function extensions()
    {
        return $this->hasOne(Extension::class, 'contract_id', 'id');
    }

    public function statements()
    {
        return $this->hasMany(Statement::class, 'contract_id', 'id');
    }

    public function deliveryTermination()
    {
        return $this->hasOne(DeliveryTermination::class, 'contract_id', 'id');
    }

    public function certainAdjustment()
    {
        return $this->hasOne(CertainAdjustment::class, 'contract_id', 'id');
    }

    public function certainStatement()
    {
        return $this->hasOne(CertainStatement::class, 'contract_id', 'id');
    }

    public function adjustment()
    {
        return $this->hasMany(Adjustment::class, 'contract_id', 'id');
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class, 'contract_id', 'id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'consultant_id', 'id');
    }

    public function designCode()
    {
        return $this->belongsToMany(DesignCode::class,'contracts_designcodes');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id', 'id');
    }

    public function paper()
    {
        return $this->hasOne(Paper::class, 'contract_id', 'id');
    }

    public function copeis()
    {
        return $this->hasMany(Copei::class, 'contract_id', 'id');
    }


    public function incrementAmount()
    {
        return $this->belongsTo(IncrementAmount::class, 'increment_amount_id'); 
    }

}
