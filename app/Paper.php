<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Paper extends Model
{
    protected $table = 'papers';

    protected $fillable = ['paper_num','contract_id', 'date', 'attachment'];

    public $timestamps = false;
  
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function copies()
    {
        return $this->belongsToMany(Copei::class, 'copies_papers');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
