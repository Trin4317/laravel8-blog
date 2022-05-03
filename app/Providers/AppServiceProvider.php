<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use App\Services\Newsletter;
use MailchimpMarketing\ApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // any Newsletter instantiation will be resolved here
        $this->app->bind(Newsletter::class, function() {
            $client = new ApiClient();

            $client->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => config('services.mailchimp.server'),
            ]);

            return new Newsletter($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // switch between which pagination style we want to use
        // default is useTailwind()
        // Paginator::useBootstrap();

        // disable all mass assignable restrictions
        // which means we don't have to provide $fillable or $guarded property for each Model
        // Model::unguard();
    }
}
