<?php

use Maatwebsite\Excel\Concerns\ToArray;
use Mockery\Matcher\Contains;
use PHPUnit\TextUI\Configuration\Merger;

function to_english_numbers(String $string): String {
    $persinaDigits1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $persinaDigits2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
    $allPersianDigits = array_merge($persinaDigits1, $persinaDigits2);
    $replaces = [...range(0, 9), ...range(0, 9)];

    return str_replace($allPersianDigits, $replaces , $string);
}

function toArrays($arrays){
    $allDataArray = [];
    foreach ($arrays as $key => $value) {
        if(is_array($value)){
            toArrays($value);
        }else{
            $allDataArray[] = $value;
        }
    }

    return $allDataArray;
}

function empty2($data){
    if($data !=null && is_array($data) && count($data) > 0)
            return false;
        else
            if( $data !=null && (is_object($data) && $data->count() > 0))
                return false;
            else
                if(($data != null && $data != '') && !is_object($data))
                    return false;
        
    return true;

}


function FieldsToString($datas,$feild)
{
    $string = '';
    foreach ($datas as $key => $value) {
        $string .= ' ,'.$value->$feild;
    }

    return $string;
}

function ChnageDate($date){
    if(str_contains($date,'/'))
        return $date;

    $years = substr($date,0,4);
    $mon = substr($date,4,2);
    $day = substr($date,6,2);

    return "$years/$mon/$day";
}


function numberFilter3($number){
    //  dd(number_format(floatval($number));
}