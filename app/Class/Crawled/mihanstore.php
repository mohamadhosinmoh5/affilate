<?php
namespace App\Class\Crawled;

use App\class\db\Tb;
use App\Models\Crawled;
use App\Models\ProductInfo;
use Symfony\Component\DomCrawler\Crawler as Crawl;
use App\Models\Product;
use App\Models\File;
use App\Models\Type;
use App\Models\ProductAttribute;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MihanStore {

    const CATEGORY_URL = "categories.php";
    const SITE_URL = 'https://mihanstore.net/';
    const REF_ID = '87321';
    const STATUS_SUCCESS = 1;

    public $product;
    public $errors=[];
    public $success=[];


    function fetch_content($url) {
        // راه‌اندازی cURL
        $ch = curl_init();
        
        // تنظیمات cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        // دریافت محتوا
        $content = curl_exec($ch);
        
        // بررسی خطا
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
            return false;
        }
        
        // بستن cURL
        curl_close($ch);
        
        return $content;
    }
    
    

    public function crawler($catId,$page)
    {

    // URL پایه دسته‌بندی
    $base_url = $this::SITE_URL.$this::CATEGORY_URL."?id=$catId&ref=87321&page=$page";
    
    // شماره صفحه شروع
    $page = 1;
    $continue_crawling = true;
    
    $all_products = [];
    
    while ($continue_crawling) {
        // URL صفحه فعلی
        $current_url = $base_url;
        // dd($current_url);
        // دریافت محتوای صفحه فعلی
        // $content = $this->fetch_content($current_url);
        // $content = file_get_contents($current_url);
        $content = Http::get($current_url);
        // $content = $content->body;
        dd($content->body());
        if ($content) {
            // بارگذاری DOM
            $dom = new \DOMDocument();
            @$dom->loadHTML($content);
            
            // استفاده از XPath برای استخراج اطلاعات
            $xpath = new \DOMXPath($dom);
            
            // جست و جوی محصولات (می‌توانید این XPath را بر اساس ساختار HTML سایت تغییر دهید)
            $products = $xpath->query("//div[contains(@class, 'product-container')]");
    
            // بررسی وجود محصولات در صفحه
            if ($products->length > 0) {
                foreach ($products as $product) {
                    // استخراج عنوان محصول (نمونه - باید بر اساس ساختار HTML واقعی تغییر کند)
                    $title = $xpath->query(".//h2[contains(@class, 'product-title')]/a", $product)->item(0)->nodeValue;
                    
                    // افزودن محصول به لیست تمام محصولات
                    $all_products[] = $title;
                }
                // افزایش شماره صفحه برای ادامه خزیدن در صفحات بعدی
                $page++;
            } else {
                // اگر هیچ محصولی وجود ندارد، خزیدن را متوقف می‌کنیم
                $continue_crawling = false;
            }
        } else {
            // اگر محتوایی دریافت نشد، خزیدن را متوقف می‌کنیم
            $continue_crawling = false;
        }
    }
    
    dd($all_products);
    // چاپ تمام محصولات استخراج‌شده
    foreach ($all_products as $product) {
        echo $product . "\n";
    }
    
        // $json = file_get_contents('https://api.Digikala.com/v1/categories/notebook-netbook-ultrabook/search/?has_selling_stock=1&page=1');

       
        $datas = null;
        $results = [];

        $ids = array_column($datas,'id');
        $exists = Tb::get('products')
                        ->join('product_infos','products.id','=','product_infos.product_id')
                        ->whereIn('products.product_id',$ids)
                        ->get()
                        ->keyBy('product_id')
                    ;
        $uniqIds = array_diff($ids,$exists->pluck('product_id')->toArray());    


        foreach ($datas as $key => $value) {
            if(in_array($value->id,$uniqIds)){
                $results['data'][] = [
                    'title_fa' => $value->title_fa,
                    'title_en' => $value->title_en,
                    'url' => Digikala::SITE_URL.$value->url->uri,
                    'product_type' => $value->product_type,
                    'mainImage' => $value->images->main->url[0],
                    'status' => 0
                ];
             }else{
                $productExist = $exists[$value->id];
                $results['data'][] = [
                    'title_fa' => $productExist->productInfo->title_fa,
                    'title_en' => $productExist->productInfo->title_en,
                    'url' => $productExist->site_url,
                    'product_type' => $value->product_type,
                    'mainImage' => $productExist->mainImage,
                    'status' => 1
                ];
             }
        }

        return $results;
    }



    public function crawlProduct($p_detail)
    {
      
        
        if(true){
            try {
                $product = file_get_contents(Digikala::PRODUCT_URL.$idProduct.'/');
                $data = json_decode($product)->data->product;
                
                $this->product =  [
                    'id' => $data->id,
                    'title_fa' => $data->title_fa,
                    'title_en' => $data->title_en,
                    'url' => $p_detail['url'],
                    'images' => $data->images->list,
                    'mainImage' => $data->images->main->url[0],
                    'colors' => $data->colors,
                    'price' => $data->default_variant->price,
                    'comments_count' => $data->comments_count,
                    'videos' => $data->videos,
                    'attributes' => $data->review->attributes,
                    'rating' => $data->rating,
                    'description' => (property_exists($data->review,'description') && !empty2($data->review->description)) ? $data->review->description : '',
                    'suggestion' => $data->suggestion,
                    'last_comments' => $data->last_comments,
                    'last_questions' => $data->last_questions,
                    'badge' => (property_exists($data,'badges') && !empty2($data->badges)) ? $data->badges :  '',
                    'warranty' => (property_exists($data,'warranty') && !empty2($data->warranty)) ? $data->warranty->title_fa :  '',
                    'order_limit'=> property_exists($data,'price') && !empty2($data->price) ? $data->price->order_limit : 0,
                    'seller' => $data->default_variant->seller,
                ];  
    
              
                    
            } catch (\Throwable $th) {
                 $this->errors[] = 'خطا در ایجاد محصول';
                return $this->errors;
            }
           

        }else{
            $this->errors[] = "محصول  ".$productExist->productInfo->title_fa." از قبل موجود می باشد";
            return $this->errors;
        }
    }


    public function crawlMultiProduct($p_details)
    {
       
    }
}