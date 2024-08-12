<?php
namespace App\Class\helpers;

class Redirect {
    
    public static function getFinalRedirectUrl($url,$timeout = 600) {
          // Initialize cURL session
          $ch = curl_init($url);

          curl_setopt_array($ch, [
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_NOBODY => true,
              CURLOPT_AUTOREFERER => true,
              CURLOPT_FOLLOWLOCATION => true, // Allows the following of redirects.
              CURLOPT_MAXREDIRS => 10, // Sets the maximum number of redirects to follow.
              CURLOPT_TIMEOUT => $timeout, // Sets a timeout to avoid excessive waiting.
              CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36", // Sets a user agent for the request.
          ]);
          
          curl_exec($ch);
      
          $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      
          curl_close($ch);
      
          return $finalUrl;
    }


}