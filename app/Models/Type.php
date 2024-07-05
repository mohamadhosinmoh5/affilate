<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Type extends Model
{
    const TYPE_PRODUCT = 'Product' ;  
    const TYPE_Post = 'Post' ;  
    
    const FILE_TYPE_IMAGE = 'Image' ;  
    const FILE_TYPE_Video = 'Video' ;  
    const FILE_TYPE_File = 'File' ;  
}
