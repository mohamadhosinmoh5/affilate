<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Copei extends Model
{
    protected $table = 'copeis';

    protected $fillable = ['contract_id ', 'text'];

    public $timestamps = false;

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function paper()
    {
        return $this->belongsToMany(Paper::class, 'copies_papers');
    }
}
