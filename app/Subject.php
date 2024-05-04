<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{
    public $timestamps = false;

    protected $table = 'subjects';

    protected $fillable = ['title','title_type'];

    public function paper()
    {

    }

    public function subject()
    {
        return $this->hasOne(Subject::class, 'subject_id');
    }
}
