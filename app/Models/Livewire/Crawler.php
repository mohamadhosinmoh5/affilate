<?php

namespace App\Livewire;

use Livewire\Component;
use App as App;
use App\Class\crawled\digikala;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductInfo;
use App\Models\Type;

class Crawler extends Component
{
    public $allCrawlers;
    public $crawler;
    public $page = 1;
    public $results = [];
    public $product;

    public function setCrawler($id)
    {
       
        $this->crawler = App\Models\Crawler::Find((int)$id);
    }

    public function readjson()
    {
        if($this->crawler->site == 'digikala')
        {
            $digiCrawl = new digikala;
            $this->results = $digiCrawl->crawler($this->crawler->url,$this->page);
        }
    }

    public function startCrawler()
    {
        
    }

    public function addProduct($p_Detail)
    {
        if($this->crawler->site == 'digikala')
        {
            $digiCrawl = new digikala;
            $this->product = $digiCrawl->crawlProduct($p_Detail);
            dd(uploadUrl($this->product['mainImage'],'upload/product'));
            if($this->product){
                $product = new App\Models\Product;
                if($this->product['mainImage']){
                    $product->mainImage = uploadUrl($this->product['mainImage'],'upload/product');
                }
                $product->site_url = $this->product['site_url'];
                
                $product->default_price = $this->product['price']->selling_price;
                $product->comments_count = $this->product['comments_count'];
                $product->suggestion = $this->product['suggestion']->count;
                $product->Save();

                $productInfo = new ProductInfo;
                $productInfo->product_id = $product->id;
                $productInfo->title_fa = $this->product['title_fa'];
                $productInfo->title_en = $this->product['title_en'];
                $productInfo->description = $this->product['description'];
                $productInfo->Save();   


                foreach ($this->product['images'] as $key => $image) {
                    $images = new File;
                    $images->type = Type::TYPE_PRODUCT;
                    $images->type_id = $product->id;
                    $images->file_type = Type::FILE_TYPE_IMAGE;
                    $images->url = $image->url;
                    $images->name = ' عکس'.$key.' '.$this->product['title_fa'];
                    $images->Save();
                }

                foreach ($this->product['attributes'] as $attribute) {
                    $productAttribute = new ProductAttribute;
                    $productAttribute->product_id = $product->id;
                    $productAttribute->key = $attribute->title;
                    $productAttribute->value = serialize($attribute->value);
                    $productAttribute->Save();
                }
            }
        }
    }

 
    public function render()
    {
        $this->allCrawlers = App\Models\Crawler::all();
        return view('livewire.crawler');
    }




}
