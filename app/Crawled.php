<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\trait\ColumnFillable;

class Crawled extends Model
{
    use ColumnFillable;

    public $timestamp = false;
}
