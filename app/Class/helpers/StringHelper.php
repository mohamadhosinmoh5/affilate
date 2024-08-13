<?php
namespace App\Class\helpers;

class StringHelper {

    public static function enCharacter($string)
    {

	    preg_match_all("/[a-zA-Z0-9]+/",$string,$matches);
        return  $matches;
    }
    
    public static function MatchStringPercent($baseText,$matchText) {

        $matches = [];
        $notMatch = [];
        foreach (self::enCharacter($matchText)[0] as $key => $value) {
            if(in_array($value,self::enCharacter($baseText)[0])){
                $matches[] = $value;
            }else{
                $notMatch[] = $value;
            }
        }

        if(
            !empty2($notMatch) && count($notMatch) > 0
            &&
            !empty2($matches) && count($matches) < count($notMatch)
        ){
            return false;
        }else{
            return true;
        }

        
    }


  
}