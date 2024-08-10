<?php
namespace App\Class\Crawled;

use App\class\db\Tb;
use App\Class\helpers\Redirect;
use App\Models\Crawled;
use App\Models\ProductInfo;
use Symfony\Component\DomCrawler\Crawler as Crawl;
use App\Models\Product;
use App\Models\File;
use App\Models\Type;
use App\Models\ProductAttribute;
use PhpParser\Node\Stmt\TryCatch;
use App\Class\helpers\SearchOnline;

class Torob {

    const API_URL = "https://api.torob.com/v4/base-product/search/?";
    const PRODUCT_URL = "https://api.torob.com/v4/base-product/details-log-click/?prk=";
    const SITE_URL = 'https://torob.com';
    const SIMILAR_URL_PRODUCT = 'https://api.torob.com/v4/base-product/similar-base-product/?page=0&prk=60f90a56-f971-434b-a1de-fc602e629b53';
    
    const STATUS_SUCCESS = 1;

    public $product;
    public $errors=[];
    public $success=[];

    public function crawler($categoryUrl,$page) 
    {

        $json = file_get_contents(Torob::API_URL.$categoryUrl.'&page='.$page);
        // $json = file_get_contents('https://api.Digikala.com/v1/categories/notebook-netbook-ultrabook/search/?has_selling_stock=1&page=1');

        $datas = json_decode($json)->results;
        
        $results = [];
        $results['head'] = [
            'عنوان',
            'لینک جهت جستجو',
            'نوع محصول',
            'تصویر محصول',
        ];

        $ids = array_column($datas,'random_key');
        $exists = Tb::get('products')
                        ->join('product_infos','products.id','=','product_infos.product_id')
                        ->whereIn('products.product_id',$ids)
                        ->get()
                        ->keyBy('product_id')
                    ;
        $uniqIds = array_diff($ids,$exists->pluck('product_id')->toArray());


        foreach ($datas as $key => $value) {
            if(in_array($value->random_key,$uniqIds)){
                $results['data'][] = [
                    'title_fa' => $value->name1,
                    'title_en' => $value->name2,
                    'url' => Torob::PRODUCT_URL.$value->random_key,
                    'product_type' => $value->price_text_mode,
                    'mainImage' => $value->image_url,
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
        $link = explode('?prk=',$p_detail['url']);
        $idProduct = explode('/',$link[1])[0];
        if(!$productExist = Product::Where(['product_id' => $idProduct])->first()){
            // try {
                $product = file_get_contents(Torob::PRODUCT_URL.$idProduct);
                $data = json_decode($product);
           
                $this->product =  [
                    'id' => $data->random_key,
                    'title_fa' => $data->name1,
                    'title_en' => $data->name2,
                    'url' => $p_detail['url'],
                    'images' => $data->media_urls,
                    'mainImage' => $data->image_url,
                    'price' => $data->price,
                    'videos' => null,
                    'attributes' => $data->key_specs,
                    'rating' => null,
                    'description' => null,
                    'seller' => $data->products_info->result,
                ];
                // dd($data);
                if($this->product){
                    $product = new Product;
                    $product->title = $this->product['title_fa'];
                    if($this->product['mainImage']){
                        $product->mainImage = uploadUrl($this->product['mainImage'],'storage/upload/product');
                    }
                    $product->site_url = $this->product['url'];
                    
                    $product->default_price = $this->product['price'];
                    $product->product_id = $this->product['id'];
                    $product->Save();
    
                    $productInfo = new ProductInfo;
                    $productInfo->product_id = $product->id;
                    $productInfo->title_fa = $this->product['title_fa'];
                    $productInfo->title_en = $this->product['title_en'];
                    $productInfo->Save();
    
    
                    foreach ($this->product['images'] as $key => $image) {
                        $images = new File;
                        $images->type = Type::TYPE_PRODUCT;
                        $images->type_id = $product->id;
                        $images->file_type = Type::FILE_TYPE_IMAGE;
                        $images->url = $image->url[0];
                        $images->name = ' عکس'.$key.' '.$this->product['title_fa'];
                        $images->Save();
                    }
                   
                    if(!empty2($this->product['attributes']) && key_exists('items',$this->product['attributes']))
                        foreach ($this->product['attributes']['items'] as $attribute) {
                            $productAttribute = new ProductAttribute;
                            $productAttribute->product_id = $product->id;
                            $productAttribute->key = $attribute->key;
                            $productAttribute->value = serialize($attribute->values);
                            $productAttribute->Save();
                        }

                    $crawled = new Crawled;
                    $crawled->title = $this->product['title_fa'];
                    $crawled->url = $this->product['url'];
                    $crawled->status = Torob::STATUS_SUCCESS;
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