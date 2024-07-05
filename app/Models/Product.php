<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\trait\ColumnFillable;

class Product extends Model
{
    use ColumnFillable;

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
}
