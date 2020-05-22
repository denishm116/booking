<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; /* Lecture 16 */
use Illuminate\Support\Facades\App; /* Lecture 34 */

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Lecture 49 */
        View::composer('backend.*', '\App\Enjoythetrip\ViewComposers\BackendComposer');


        /* Lecture 16 */
        View::composer('frontend.*', function ($view) {
            $view->with('placeholder', asset('images/placeholder.jpg'));
        });

        /* Lecture 34 */
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

        /* Lecture 55 */
        if (App::environment('local'))
        {

            /* Lecture 13 */
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


        /* Lecture 27 */
        $this->app->bind(\App\Enjoythetrip\Interfaces\BackendRepositoryInterface::class,function()
        {
            return new \App\Enjoythetrip\Repositories\BackendRepository;
        });
    }
}

