<?php

namespace App\Jobs;

use App\Class\helpers\SearchOnline;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class addSellersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $products = Product::Where('job_status' ,0)->with('productInfo')->latest()->take(10)->get();

        foreach ($products as $product) {
            $results = SearchOnline::google($product->title);
            if ($results) {
                foreach ($results as $result) {
                    $product->sellers->create([
                        'name' => ,
                        'link' => ,
                    ]);
                }
            }
        }
    }
}
