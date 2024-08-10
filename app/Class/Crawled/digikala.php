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

class Digikala {

    const API_URL = "https://api.digikala.com/v1/categories/";
    const PRODUCT_URL = "https://api.digikala.com/v2/product/";
    const SITE_URL = 'https://digikala.com';
    
    const STATUS_SUCCESS = 1;

    public $product;
    public $errors=[];
    public $success=[];

    public function crawler($categoryUrl,$page) 
    {

        $json = file_get_contents(Digikala::API_URL.$categoryUrl.'/search/?has_selling_stock=1&page='.$page);
        // $json = file_get_contents('https://api.digikala.com/v1/categories/notebook-netbook-ultrabook/search/?has_selling_stock=1&page=1');

       
        $datas = json_decode($json)->data->products;
        $results = [];
        $results['head'] = [
            'عنوان',
            'لینک جهت جستجو',
            'نوع محصول',
            'تصویر محصول',
        ];

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
      
        $link = explode('dkp-',$p_detail['url']);
        $idProduct = explode('/',$link[1])[0];
        if(!$productExist = Product::Where(['product_id' => $idProduct])->first()){
            // try {
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
                if($this->product){
                    $product = new Product;
                    if($this->product['mainImage']){
                        $product->mainImage = uploadUrl($this->product['mainImage'],'storage/upload/product');
                    }
                    $product->site_url = $this->product['url'];
                    $product->title = $this->product['title_fa'];
                    $product->default_price = $this->product['price']->selling_price;
                    $product->comments_count = $this->product['comments_count'];
                    $product->suggestion = $this->product['suggestion']->count;
                    $product->product_id = $this->product['id'];
                    $product->Save();
    
                    $productInfo = new ProductInfo;
                    $productInfo->product_id = $product->id;
                    $productInfo->title_fa = $this->product['title_fa'];
                    $productInfo->title_en = $this->product['title_en'];
                    $productInfo->description = $this->product['description'];
                    $productInfo->Save();   
    
                    if(!empty2($this->product['videos'])){
                        foreach ($this->product['videos'] as $key => $video) {
                            $video = new File;
                            $video->type = Type::TYPE_PRODUCT;
                            $video->type_id = $product->id;
                            $video->file_type = Type::FILE_TYPE_Video;
                            $video->url = $video->url;
                            $video->name = ' عکس'.$key.' '.$this->product['title_fa'];
                            $video->Save();
                        }
                    }
    
                    foreach ($this->product['images'] as $key => $image) {
                        $images = new File;
                        $images->type = Type::TYPE_PRODUCT;
                        $images->type_id = $product->id;
                        $images->file_type = Type::FILE_TYPE_IMAGE;
                        $images->url = $image->url[0];
                        $images->name = ' عکس'.$key.' '.$this->product['title_fa'];
                        $images->Save();
                    }
    
                    foreach ($this->product['attributes'] as $attribute) {
                        $productAttribute = new ProductAttribute;
                        $productAttribute->product_id = $product->id;
                        $productAttribute->key = $attribute->title;
                        $productAttribute->value = serialize($attribute->values);
                        $productAttribute->Save();
                    }

                    $crawled = new Crawled;
                    $crawled->title = $this->product['title_fa'];
                    $crawled->url = $this->product['url'];
                    $crawled->status = Digikala::STATUS_SUCCESS;
                    $crawled->title = $this->product['title_fa'];
                    $crawled->crawled_id = $this->product['id'];
                    $crawled->Save();

                    $this->success[] = $this->product['title_fa']."با موفقیت ایجاد شد ";

                    return $this->success;
                }
            // } catch (\Throwable $th) {
                 $this->errors[] = 'خطا در ایجاد محصول';
                return $this->errors;
            // }
           

        }else{
            $this->errors[] = "محصول  ".$productExist->productInfo->title_fa." از قبل موجود می باشد";
            return $this->errors;
        }
    }


    public function crawlMultiProduct($p_details)
    {
        $result=[];
        foreach ($p_details as $key => $p_detail) {
            $result[] = $this->crawlProduct($p_detail);
        }

        if(!empty2($result))
            return $result;
        else
            return false;
    }
}