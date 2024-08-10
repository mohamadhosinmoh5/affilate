<?php

namespace App\Livewire;

use Livewire\Component;
use App as App;
use App\Class\crawled\Digikala;
use App\Class\Crawled\Torob;
use Illuminate\Support\Facades\DB;

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
        $this->crawler =  DB::table('crawlers')->Find((int)$id);
    }

    public function readjson()
    {

        if($this->crawler->site == 'torob')
        {
            $torobCrawler = new Torob;
            $this->results = $torobCrawler->crawler($this->crawler->url,$this->page);
        }

        if($this->crawler->site == 'digikala')
        {
            $digiCrawl = new Digikala;
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

        if($this->crawler->site == 'torob')
        {
            $torobCrawl = new Torob;
            if($res = $torobCrawl->crawlProduct($p_Detail))
                $this->notif = $res;
        }

        if($this->crawler->site == 'digikala')
        {
            $digiCrawl = new Digikala;
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

        if($this->crawler->site == 'torob')
        {
            $digiCrawl = new Torob;
            if($res = $digiCrawl->crawlMultiProduct($details))
                $this->notif = $res;
        }

        if($this->crawler->site == 'digikala')
        {
            $digiCrawl = new Digikala;
            if($res = $digiCrawl->crawlMultiProduct($details))
                $this->notif = $res;
        }
    }

    public function closeModal()
    {
        $this->notif = null ;
    }
 
    public function render()
    {
        $this->allCrawlers = DB::table('crawlers')->get();
        return view('livewire.crawler');
    }


}



