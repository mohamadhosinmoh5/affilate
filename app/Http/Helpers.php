<?php

use Nette\Utils\Random;
use Illuminate\Support\Facades\Storage; 

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
            $link = explode('.jpg',$url);
            $link = $link[0].'.jpg';

            if(!is_dir($dir)) mkdir($dir,0777,true);

            $fileName = $dir.'/'.basename($link);
            if (file_put_contents($fileName, file_get_contents($link)))
                return $fileName;
            else
                echo $url; 
    }
}