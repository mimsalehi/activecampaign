<?php

namespace MimSalehi\ActiveCampaign;

use Illuminate\Support\ServiceProvider;
use MimSalehi\ActiveCampaign\Classes\Contact;
use MimSalehi\ActiveCampaign\Classes\CustomField;
use MimSalehi\ActiveCampaign\Classes\Deal;
use MimSalehi\ActiveCampaign\Classes\EventTracking;

class ActiveCampaignServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mimsalehi');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'mimsalehi');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/activecampaign.php', 'activecampaign');

        // Register the service the package provides.
        $this->app->singleton('activecampaign', function ($app) {
            return new ActiveCampaign;
        });
        $this->app->bind('contact', function ($app) {
            return new Contact();
        });
        $this->app->bind('event', function ($app) {
            return new EventTracking();
        });
        $this->app->bind('customField', function ($app) {
            return new CustomField();
        });
        $this->app->bind('deal', function ($app) {
            return new Deal();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['activecampaign', 'contact', 'eventtracking', 'customField', 'deal'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/activecampaign.php' => config_path('activecampaign.php'),
        ], 'activecampaign.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/mimsalehi'),
        ], 'activecampaign.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/mimsalehi'),
        ], 'activecampaign.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/mimsalehi'),
        ], 'activecampaign.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
