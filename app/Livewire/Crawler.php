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

    public function setCrawler($id)
    {
       
        $this->crawler = App\Crawler::Find((int)$id);
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
            dd($this->product);
        }
    }

 
    public function render()
    {
        $this->allCrawlers = App\Crawler::all();
        return view('livewire.crawler');
    }




}
