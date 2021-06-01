<?php /** @noinspection PhpUnused */

/** @noinspection PhpExpressionAlwaysNullInspection */

namespace MCDev\IlluminateConnectionEvents\Tests {

    use Illuminate\Contracts\Container\BindingResolutionException;
    use MCDev\IlluminateConnectionEvents\Tests\Stubs\PdoStub;
    use Mockery as m;

    class EventTest extends TestCase
    {

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlConnectingEventGetsParameters()
        {
            $this->driverConnectingEventGetsParameters('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlConnectingEventGetsParameters()
        {
            $this->driverConnectingEventGetsParameters('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteConnectingEventGetsParameters()
        {
            $this->driverConnectingEventGetsParameters('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvConnectingEventGetsParameters()
        {
            $this->driverConnectingEventGetsParameters('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverConnectingEventGetsParameters($driver)
        {
            if (!$this->app->bound('events')) {
                $this->markTestSkipped('The Illuminate Event Dispatcher is not available.');
            }

            $config = ['name' => $driver];

            $_SERVER['__event.test.DatabaseConnecting'] = null;
            $events = $this->app['events'];
            $events->listen(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting',
                function ($event) {
                    $_SERVER['__event.test.DatabaseConnecting'] = $event;
                }
            );

            $connector = $this->getPdoStubConnector($driver);
            $connector->connect($config);
            $event = $_SERVER['__event.test.DatabaseConnecting'];

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting',
                $event
            );
            $this->assertSame($connector, $event->connector);
            $this->assertEquals($driver, $event->connectionName);
            $this->assertEquals($config, $event->config);
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlConnectedEventGetsParameters()
        {
            $this->driverConnectedEventGetsParameters('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlConnectedEventGetsParameters()
        {
            $this->driverConnectedEventGetsParameters('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteConnectedEventGetsParameters()
        {
            $this->driverConnectedEventGetsParameters('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvConnectedEventGetsParameters()
        {
            $this->driverConnectedEventGetsParameters('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverConnectedEventGetsParameters($driver)
        {
            if (!$this->app->bound('events')) {
                $this->markTestSkipped('The Illuminate Event Dispatcher is not available.');
            }

            $config = ['name' => $driver];

            $_SERVER['__event.test.DatabaseConnected'] = null;
            $events = $this->app['events'];
            $events->listen(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnected',
                function ($event) {
                    $_SERVER['__event.test.DatabaseConnected'] = $event;
                }
            );

            $connector = $this->getPdoStubConnector($driver);
            $connector->connect($config);
            $event = $_SERVER['__event.test.DatabaseConnected'];

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnected',
                $event
            );
            $this->assertSame($connector, $event->connector);
            $this->assertEquals($driver, $event->connectionName);
            $this->assertEquals($config, $event->config);
            $this->assertInstanceOf('MCDev\IlluminateConnectionEvents\Tests\Stubs\PdoStub', $event->pdo);
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlConnectingEventCanModifyConfig()
        {
            $this->driverConnectingEventCanModifyConfig('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlConnectingEventCanModifyConfig()
        {
            $this->driverConnectingEventCanModifyConfig('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteConnectingEventCanModifyConfig()
        {
            $this->driverConnectingEventCanModifyConfig('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvConnectingEventCanModifyConfig()
        {
            $this->driverConnectingEventCanModifyConfig('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverConnectingEventCanModifyConfig($driver)
        {
            if (!$this->app->bound('events')) {
                $this->markTestSkipped('The Illuminate Event Dispatcher is not available.');
            }

            $events = $this->app['events'];
            $events->listen(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting',
                function ($event) {
                    $event->config['modified'] = true;
                }
            );

            $_SERVER['__event.test.parameter'] = [];
            $connector = $this->getMockedConnector($driver);
            $connector->shouldReceive('parentConnect')
                ->with(m::on(function ($config) {
                    $_SERVER['__event.test.parameter'] = $config;
                    return true;
                }))
                ->andReturn(new PdoStub());

            $connector->connect(['name' => $driver]);

            $this->assertArrayHasKey('modified', $_SERVER['__event.test.parameter']);
        }
    }
}
