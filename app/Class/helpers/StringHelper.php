<?php
namespace App\Class\helpers;

class StringHelper {

    public static function enCharacter($string)
    {

	    preg_match_all("/[a-zA-Z0-9]+/",$string,$matches);
        return  $matches;
    }
    
    public static function MatchStringPercent($baseText,$matchText) {

        $subscribe = array_intersect(self::enCharacter($baseText)[0],self::enCharacter($matchText)[0]);
        $diff = array_diff(self::enCharacter($baseText)[0],self::enCharacter($matchText)[0]);
        $matches = [];
        foreach (self::enCharacter($matchText)[0] as $key => $value) {
            if(!in_array($value,self::enCharacter($baseText)[0])){
                $matches[] = $value;
            }
        }

        if(!empty2($matches) && count($matches) > 0){
            return false;
        }else{
            return true;
        }
    }


  
}