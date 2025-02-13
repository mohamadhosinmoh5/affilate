<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\trait\ColumnFillable;

class ProductAttribute extends Model
{
    use ColumnFillable;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

