<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\trait\ColumnFillable;

class ProductInfo extends Model
{
    use ColumnFillable;
    protected $table = 'product_infos';


  
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
