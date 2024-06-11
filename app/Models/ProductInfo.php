<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\trait\ColumnFillable;

class ProductInfo extends Model
{
    use ColumnFillable;
    protected $table = 'product_infos';
}
