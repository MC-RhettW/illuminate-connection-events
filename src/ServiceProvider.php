<?php
namespace MCDev\IlluminateConnectionEvents;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConnector(
            'mysql',
            'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\MySqlConnector'
        );
        $this->registerConnector(
            'pgsql',
            'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\PostgresConnector'
        );
        $this->registerConnector(
            'sqlite',
            'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\SQLiteConnector'
        );
        $this->registerConnector(
            'sqlsrv',
            'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\SqlServerConnector'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function registerConnector($driver, $class)
    {
        $this->app->bind('db.connector.'.$driver, function ($app) use ($class) {
            $connector = new $class();

            if ($app->bound('events')) {
                $connector->setEventDispatcher($app['events']);
            }

            return $connector;
        });
    }
}
