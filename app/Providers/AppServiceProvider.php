<?php

namespace App\Providers;

use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\FormFields\DateFaHandler;
use TCG\Voyager\FormFields\NumberFilterHandler;
use TCG\Voyager\FormFields\TotalPriceText;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        Voyager::addFormField(DateFaHandler::class);
        Voyager::addFormField(NumberFilterHandler::class);
        Voyager::addFormField(TotalPriceText::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
