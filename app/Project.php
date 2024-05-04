<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = ['company_name', 'contract_num', 'desc', 'contract_date','delay_date','finish_date'];
   

 
    public function papers()
    {
        return $this->hasMany(Paper::class, 'project_id', 'id');
    }

    public function copeis()
    {
        return $this->hasMany(copei::class, 'project_id', 'id');
    }
}
