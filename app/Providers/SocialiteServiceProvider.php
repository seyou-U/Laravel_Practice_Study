<?php

namespace App\Providers;

use App\Foundation\Socialite\AmazonProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteManager;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * extendメソッドを利用して認証メソッドの追加を行う
     * @params Factory|SocialiteManager $factory
     */
    protected function boot(Factory $factory)
    {
        $factory->extend('amazon', function(Application $app) use ($factory) {
            return $factory->buildProvider(
                AmazonProvider::class,
                $app['config']['services.amazon']
            );
        });
    }
}
