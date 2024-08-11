<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\trait\ColumnFillable;

class Categorei extends Model
{
    use ColumnFillable;


    public function product()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function crawlers()
    {
        return $this->hasMany(Crawler::class, 'category_id');
    }
}
