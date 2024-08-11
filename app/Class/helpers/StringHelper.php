<?php
namespace App\Class\helpers;

class StringHelper {
    
    public static function MatchStringPercent($baseText,$matchText) {
       // محاسبه درصد مشابهت
        similar_text($baseText, $matchText, $percentSimilarText);

        // محاسبه Levenshtein distance
        $levenshteinDistance = levenshtein($baseText, $matchText);

        // ترکیب نتایج
        $combinedScore = ($percentSimilarText - $levenshteinDistance) / 2; 

        return (int)$combinedScore;
    }

}