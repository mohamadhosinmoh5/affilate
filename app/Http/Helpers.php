<?php

if (! function_exists('empty2')) {
    function empty2($data) {
        if( is_object($data) && (array) $data !== [])
            return false;
        if(is_array($data) && !empty($data) && count($data) > 0)
            return false;
        if(is_string($data) && strlen($data) > 0)
            return false;

         return true;
    }
}

if (! function_exists('uploadUrl')) {
    function uploadUrl($url,$dir)
    {
            $file_name = basename($url); 
            $file_path = $dir . $file_name;
            if(!is_dir($file_path)) mkdir($file_path);
                Illuminate\Support\Facades\Storage::makeDirectory(public_path().'/'.$file_path);
            
            if (file_put_contents($file_path, file_get_contents($url))) 
                return $file_path;
            else
                echo $url; 
    }
}