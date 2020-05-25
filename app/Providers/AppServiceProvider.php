<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer('backend.*', '\App\Enjoythetrip\ViewComposers\BackendComposer');


        View::composer('frontend.*', function ($view) {
            $view->with('placeholder', asset('images/placeholder.jpg'));
        });

        if (App::environment('local'))
        {
            View::composer('*', function ($view) {
                $view->with('novalidate', 'novalidate');
            });
        }
        else
        {
            View::composer('*', function ($view) {
                $view->with('novalidate', null);
            });
        }
        setlocale(LC_TIME, 'ru_RU.UTF-8');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        if (App::environment('local'))
        {


            $this->app->bind(\App\Enjoythetrip\Interfaces\FrontendRepositoryInterface::class,function()
            {
                return new \App\Enjoythetrip\Repositories\FrontendRepository;
            });

        }
        else
        {

            $this->app->bind(\App\Enjoythetrip\Interfaces\FrontendRepositoryInterface::class,function()
            {
                return new \App\Enjoythetrip\Repositories\CachedFrontendRepository;
            });

        }



        $this->app->bind(\App\Enjoythetrip\Interfaces\BackendRepositoryInterface::class,function()
        {
            return new \App\Enjoythetrip\Repositories\BackendRepository;
        });
    }
}

