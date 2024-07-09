<?php

namespace App\Livewire;

use Livewire\Component;
use App as App;
use App\Class\crawled\digikala;

class Crawler extends Component
{
    public $allCrawlers;
    public $crawler;
    public $page = 1;
    public $results = [];
    public $product;
    public $Allproduct;
    public $notif= [];

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


    public function crawlPage($page)
    {
        $this->page = $page;
        $this->readjson();
    }

    public function addProduct($p_Detail)
    {
        if($this->crawler->site == 'digikala')
        {
            $digiCrawl = new digikala;
            if($res = $digiCrawl->crawlProduct($p_Detail))
                $this->notif = $res;
        }
    }
    public function addToAllProduct($product)
    {
        $this->Allproduct[] = $product;
    }

    public function addAllProduct($details)
    {
        if($this->crawler->site == 'digikala')
        {
            $digiCrawl = new digikala;
            if($res = $digiCrawl->crawlMultiProduct($details))
                $this->notif = $res;
        }
    }
 
    public function render()
    {
        $this->allCrawlers = App\Models\Crawler::all();
        return view('livewire.crawler');
    }




}
