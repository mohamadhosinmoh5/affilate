<?php
namespace App\Class\helpers;

class StringHelper {

    public static function enCharacter($string)
    {

	    preg_match_all("/[a-zA-Z0-9]+/",$string,$matches);
        return  $matches[0];
    }

    public static function faCharacter($string)
    {
        $pattern = '/\b[\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}]{4,}\b/u';
	    preg_match_all($pattern,$string,$matches);
        return  $matches[0];
    }
    
    public static function MatchStringPercent($baseText,$matchText) {

        $matches = [];
        $notMatch = [];
        foreach (self::enCharacter($matchText) as $key => $value) {
            if(in_array($value,self::enCharacter($baseText))){
                $matches[] = $value;
            }else{
                $notMatch[] = $value;
            }
        }

        foreach (self::faCharacter($matchText) as $key => $value) {
            if(in_array($value,self::faCharacter($baseText))){
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