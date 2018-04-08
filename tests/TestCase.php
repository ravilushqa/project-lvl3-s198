<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        /**
         * code below for using route helper in tests
         * https://laravel-news.com/using-named-routes-lumen-test
         */
        $app = require __DIR__.'/../bootstrap/app.php';

        $uri = $app->make('config')->get('app.url', 'http://localhost');

        $components = parse_url($uri);

        $server = $_SERVER;

        if (isset($components['path'])) {
            $server = array_merge($server, [
                'SCRIPT_FILENAME' => $components['path'],
                'SCRIPT_NAME' => $components['path'],
            ]);
        }

        $app->instance('request', \Illuminate\Http\Request::create(
            $uri, 'GET', [], [], [], $server
        ));

        return $app;
    }
}
