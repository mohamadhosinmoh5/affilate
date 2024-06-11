<?php
namespace App\Class\Crawled;

use Symfony\Component\DomCrawler\Crawler as Crawl;

class digikala {

    const API_URL = "https://api.digikala.com/v1/categories/";
    const PRODUCT_URL = "https://api.digikala.com/v2/product/";
    const SITE_URL = 'https://digikala.com';

    public function crawler($categoryUrl,$page) 
    {

        $json = file_get_contents(digikala::API_URL.$categoryUrl.'/search/?has_selling_stock=1&page='.$page);
        // $json = file_get_contents('https://api.digikala.com/v1/categories/notebook-netbook-ultrabook/search/?has_selling_stock=1&page=1');

        $datas = json_decode($json)->data->products;
        dd(json_decode($json)->data);
        $results = [];
        $results['head'] = [
            'عنوان',
            'لینک جهت جستجو',
            'نوع محصول',
            'تصویر محصول',
        ];
        foreach ($datas as $key => $value) {
            $results['data'][] = [
                'title_fa' => $value->title_fa,
                'title_en' => $value->title_en,
                'url' => digikala::SITE_URL.$value->url->uri,
                'product_type' => $value->product_type,
                'mainImage' => $value->images->main->url[0],
            ];
        }

        return $results;
    }



    public function crawlProduct($p_detail)
    {
        $link = explode('dkp-',$p_detail['url']);
        $idProduct = explode('/',$link[1])[0];
        $product = file_get_contents(digikala::PRODUCT_URL.$idProduct.'/');
        $data = json_decode($product)->data->product;
       
        return [
            'id' => $data->id,
            'title_fa' => $data->title_fa,
            'title_en' => $data->title_en,
            'images' => $data->images->list,
            'mainImage' => $data->images->main->url[0],
            'colors' => $data->colors,
            'price' => $data->default_variant->price,
            'comments_count' => $data->comments_count,
            'videos' => $data->videos,
            'review' => $data->review,
            'suggestion' => $data->suggestion,
            'last_comments' => $data->last_comments,
            'last_questions' => $data->last_questions,
            'review' => $data->review,
        ];  
    }

}