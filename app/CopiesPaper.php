<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CopiesPaper extends Model
{
    protected $table = 'copies_papers';

    protected $fillable = ['Copei_id', 'paper_id'];

    public $timestamps = false;
}
