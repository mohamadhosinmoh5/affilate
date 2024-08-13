<?php
namespace App\Class\helpers;

use GuzzleHttp\Client;
class SearchOnline{

    const TOTALSEARCH = 20;
    public static $results = [];

    public static function google($query,$start=1)
    {

        // کلید API و شناسه موتور جستجوی سفارشی (cx)
        $apiKey = 'AIzaSyCmIIQoDGr8Kj6s2XO-jYTfwnWDaAZu3mE';
        $cx = 'e4e0e5b8929de4c46';

        // تعداد نتایج در هر درخواست
        $num = self::TOTALSEARCH;
        
        // ایجاد کلاینت Guzzle
        $client = new Client();
        
        $results1 = self::fetchResults($client, $apiKey, $cx, $query, 1);
        $results2 = self::fetchResults($client, $apiKey, $cx, $query,10);
        $results = array_merge($results1['items'],$results2['items']);
        
        if (isset($results)) {
            foreach ($results as $item) {

                if(
                    !str_contains($item['link'],'torob') &&
                     !str_contains($item['link'],'zoomit') && 
                     !str_contains($item['link'],'emalls') &&
                     StringHelper::MatchStringPercent($query,$item['title'])
                     )
                    self::$results[] = [
                        'title' => $item['title'],
                        'link' => $item['link'],
                        'displayLink' => $item['displayLink'],
                    ];
            }
        }

        return self::$results;

    }

    public static function fetchResults($client, $apiKey, $cx, $query,$start) {
        $response = $client->request('GET', 'https://customsearch.googleapis.com/customsearch/v1', [
            'query' => [
                'key' => $apiKey,
                'cx' => $cx,
                'q' => $query,
                'start' => $start
            ]
        ]);
    
        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        } else {
            echo "Error: " . $response->getStatusCode();
            return [];
        }
    }
        
            
    public static function searchWikipedia($query) {
        // ساخت URL درخواست
        $url = 'https://fa.wikipedia.org/w/api.php?action=query&list=search&srsearch=' . urlencode($query) . '&format=json&utf8=1';
    
        // استفاده از cURL برای ارسال درخواست
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // دریافت پاسخ
        $response = curl_exec($ch);
        curl_close($ch);
        
        // تبدیل پاسخ JSON به آرایه PHP
        $data = json_decode($response, true);
        
        // بررسی نتیجه جستجو
        if (isset($data['query']['search'][0])) {
            // اولین نتیجه جستجو
            $title = $data['query']['search'][0]['title'];
            
            // باز کردن صفحه نتیجه جستجو برای دریافت محتوای کامل
            return self::getWikipediaPageContent($title);
        } else {
            return "No results found for '$query'.";
        }
    }
    
    // تابعی برای دریافت محتوای صفحه ویکی‌پدیا
    public static function getWikipediaPageContent($title) {
        $url = 'https://fa.wikipedia.org/w/api.php?action=query&prop=extracts&explaintext&titles=' . urlencode($title) . '&format=json&utf8=1';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // دریافت پاسخ
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        return $data;
        // استخراج محتوا از صفحه
        // $pages = $data['query']['pages'];
        // foreach ($pages as $page) {
        //     return $page['extract'];
        // }
        
        // return "Content not found for '$title'.";
    }

    public static function OpenAI($query) {
        // آدرس API و کلید API خود را وارد کنید
        $api_url = 'https://api.openai.com/v1/engines/davinci-codex/completions';
        $api_key = 'YOUR_OPENAI_API_KEY';
    
        // داده‌های درخواست
        $data = [
            "prompt" => $query,
            "max_tokens" => 150,
            "n" => 1,
            "stop" => null,
            "temperature" => 0.5
        ];
    
        // تبدیل داده به JSON
        $data_string = json_encode($data);
    
        // استفاده از cURL برای ارسال درخواست
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    
        // دریافت پاسخ
        $response = curl_exec($ch);
        curl_close($ch);
    
        // تبدیل پاسخ JSON به آرایه PHP
        $response_data = json_decode($response, true);
    
        return $response_data['choices'][0]['text'];
    }
        // تابعی برای ارسال درخواست به Hugging Face API
    public static function HuggingFace($query) {
        // آدرس API و کلید API خود را وارد کنید
        $api_url = 'https://api-inference.huggingface.co/models/Helsinki-NLP/opus-mt-en-fa';
        $api_key = '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';

        // داده‌های درخواست
        $data = [
            "inputs" => $query
        ];

        // تبدیل داده به JSON
        $data_string = json_encode($data);

        // استفاده از cURL برای ارسال درخواست
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // دریافت پاسخ
        $response = curl_exec($ch);
        curl_close($ch);

        // تبدیل پاسخ JSON به آرایه PHP
        $response_data = json_decode($response, true);
        dd($response_data);
        // بررسی که آیا پاسخ معتبر است
        if (isset($response_data[0]['translation_text'])) {
            return $response_data[0]['translation_text'];
        } else {
            return "An error occurred.";
        }
    }

}