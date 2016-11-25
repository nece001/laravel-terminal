<?php

use Mockery as m;
use Recca0120\Terminal\TerminalServiceProvider;

class TerminalServiceProviderTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_boot()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $app = m::mock('Illuminate\Contracts\Foundation\Application, ArrayAccess');
        $config = m::mock('Illuminate\Contracts\Config\Repository, ArrayAccess');
        $request = m::mock('Illuminate\Http\Request');
        $router = m::mock('Illuminate\Routing\Router');
        $view = m::mock('Illuminate\Contracts\View\Factory');
        $events = m::mock('Illuminate\Contracts\Events\Dispatcher');

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $router->shouldReceive('group')->with(m::any(), m::type('Closure'))->andReturnUsing(function ($options, $closure) use ($router) {
            // $closure($router);
        });

        $view->shouldReceive('addNamespace')->with('terminal', m::any());

        $config
            ->shouldReceive('get')->with('terminal', [])->once()->andReturn([
                'whitelists' => ['127.0.0.1'],
            ])
            ->shouldReceive('set')->with('terminal', m::any())->once()
            ->shouldReceive('offsetExists')->with('terminal')->andReturn(true)
            ->shouldReceive('offsetGet')->with('terminal')->once()->andReturn([
                'enabled' => true,
                'whitelists' => ['127.0.0.1'],
            ])
            ->shouldReceive('offsetGet')->with('terminal.commands')->once()->andReturn([]);

        $request
            ->shouldReceive('getClientIp')->once()->andReturn('127.0.0.1');

        $app
            ->shouldReceive('offsetGet')->with('config')->andReturn($config)
            ->shouldReceive('resourcePath')
            ->shouldReceive('configPath')
            ->shouldReceive('basePath')
            ->shouldReceive('publicPath')
            ->shouldReceive('offsetGet')->with('view')->once()->andReturn($view)
            ->shouldReceive('routesAreCached')->once()->andReturn(false)
            ->shouldReceive('offsetGet')->with('events')->times(3)->andReturn($events)
            ->shouldReceive('version')->andReturn('testing')
            ->shouldReceive('singleton')->with('Recca0120\Terminal\Kernel', 'Recca0120\Terminal\Kernel')
            ->shouldReceive('singleton')->with('Recca0120\Terminal\Application', m::type('Closure'))->andReturnUsing(function ($className, $closure) use ($app) {
                return $closure($app);
            })
            ->shouldReceive('make')->andReturnUsing(function () {
                $command = m::mock('Symfony\Component\Console\Command\Command');

                $command->shouldReceive('setApplication')
                    ->shouldReceive('isEnabled')->andReturn(false);

                return $command;
            })
            ->shouldReceive('runningInConsole')->andReturn(true);

        $events
            ->shouldReceive('fire')->once()
            ->shouldReceive('firing')->once();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $serviceProvider = new TerminalServiceProvider($app);
        $serviceProvider->register();
        $serviceProvider->boot($request, $router, $config);
    }
}

if (function_exists('env') === false) {
    function env($env)
    {
        switch ($env) {
            case 'APP_ENV':
                return 'local';
                break;

            case 'APP_DEBUG':
                return true;
                break;
        }
    }
}