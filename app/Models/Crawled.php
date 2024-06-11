<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\trait\ColumnFillable;

class Crawled extends Model
{
    use ColumnFillable;

    public $timestamp = false;
}
