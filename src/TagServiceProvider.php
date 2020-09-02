<?php

namespace Haxibiao\Tag;

use Illuminate\Support\ServiceProvider;

class TagServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bindPathsInContainer();

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

    public function boot()
    {
        //安装时需要
        if ($this->app->runningInConsole()) {

            $this->loadMigrationsFrom($this->app->make('path.haxibiao-tag.migrations'));

            //发布 graphql
            $this->publishes([
                __DIR__ . '/../graphql/tag' => base_path('graphql/tag'),
            ], 'tag-graphql');
        }
    }

    protected function bindPathsInContainer()
    {
        foreach ([
                     'path.haxibiao-tag'            => $root = dirname(__DIR__),
                     'path.haxibiao-tag.config'     => $root . '/config',
                     'path.haxibiao-tag.database'   => $database = $root . '/database',
                     'path.haxibiao-tag.migrations' => $database . '/migrations',
                     'path.haxibiao-tag.graphql'    => $root . '/graphql',
                 ] as $abstract => $instance) {
            $this->app->instance($abstract, $instance);
        }
    }
}
