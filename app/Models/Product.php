<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\trait\ColumnFillable;

class Product extends Model
{
    use ColumnFillable;

    const TYPE_DIGIKALA = 0;
    const TYPE_TOROB = 1;

    public function getImages()
    {
        return File::Where(['type_id' => $this->id,'file_type' => Type::FILE_TYPE_IMAGE,'type' => Type::TYPE_PRODUCT ])->get();
    }


    public function getFiles()
    {
        return File::Where(['type_id' => $this->id,'file_type' => Type::FILE_TYPE_File,'type' => Type::TYPE_PRODUCT ])->get();
    }


    public function getVideos()
    {
        return File::Where(['type_id' => $this->id,'file_type' => Type::FILE_TYPE_Video,'type' => Type::TYPE_PRODUCT ])->get();
    }


    public function productInfo()
    {
        return $this->hasOne(ProductInfo::class, 'product_id');
    }

    public function productAttribute()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function sellers()
    {
        return $this->hasMany(Seller::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Categorei::class, 'category_id');
    }
}
