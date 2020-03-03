<?php

/*
 * This file is part of the zoontao/school.
 *
 * (c) bell <zzz@zoontao.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZoonTao\UnionSchool;


use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

use  ZoonTao\UnionSchool\App\Application as app;

/**
 * Class ServiceProvider.
 *
 * @author bell <zzz@zoontao.com>
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/config.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('school.php')], 'union-school');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('school');
        }

        $this->mergeConfigFrom($source, 'school');
    }


    /**
     * Register the provider.
     */
    public function register()
    {
        $this->setupConfig();

        $apps = [
            'app' => app::class,
            'work' => Work::class,
            'mini_program' => MiniProgram::class,
            'payment' => Payment::class,
            'open_platform' => OpenPlatform::class,
            'open_work' => OpenWork::class,
        ];

        foreach ($apps as $name => $class) {
            if (empty(config('school.'.$name))) {
                continue;
            }

            if ($config = config('school.route.'.$name)) {
                $this->getRouter()->group($config['attributes'], function ($router) use ($config) {
                    $router->post($config['uri'], $config['action']);
                });
            }

            if (!empty(config('school.'.$name.'.app_id')) || !empty(config('school.'.$name.'.corp_id'))) {
                $accounts = [
                    'default' => config('school.'.$name),
                ];
                config(['school.'.$name.'.default' => $accounts['default']]);
            } else {
                $accounts = config('school.'.$name);
            }

            foreach ($accounts as $account => $config) {
                $this->app->singleton("school.{$name}.{$account}", function ($laravelApp) use ($name, $account, $config, $class) {
                    $app = new $class(array_merge(config('school.defaults', []), $config));
                    if (config('school.defaults.use_laravel_cache')) {
                        $app['cache'] = $laravelApp['cache.store'];
                    }
                    $app['request'] = $laravelApp['request'];

                    return $app;
                });
            }
            $this->app->alias("school.{$name}.default", 'school.'.$name);
            $this->app->alias("school.{$name}.default", 'unionschool.'.$name);

            $this->app->alias('school.'.$name, $class);
            $this->app->alias('unionschool.'.$name, $class);
        }
    }

    protected function getRouter()
    {
        if ($this->app instanceof LumenApplication && !class_exists('Laravel\Lumen\Routing\Router')) {
            return $this->app;
        }

        return $this->app->router;
    }
}
