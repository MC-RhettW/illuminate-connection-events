<?php /** @noinspection PhpUnused */

namespace MCDev\IlluminateConnectionEvents\Tests {

    use Illuminate\Contracts\Container\BindingResolutionException;

    class ConnectorTest extends TestCase
    {

        public function testDbFactoryMakesExtendedMysqlConnector()
        {
            $connector = $this->getDbFactoryConnector('mysql');

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\MySqlConnector',
                $connector
            );
        }

        public function testDbFactoryMakesExtendedPgsqlConnector()
        {
            $connector = $this->getDbFactoryConnector('pgsql');

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\PostgresConnector',
                $connector
            );
        }

        public function testDbFactoryMakesExtendedSqliteConnector()
        {
            $connector = $this->getDbFactoryConnector('sqlite');

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\SQLiteConnector',
                $connector
            );
        }

        public function testDbFactoryMakesExtendedSqlsrvConnector()
        {
            $connector = $this->getDbFactoryConnector('sqlsrv');

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\SqlServerConnector',
                $connector
            );
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlConnectorUsesEventsByDefault()
        {
            $this->driverConnectorUsesEventsByDefault('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlConnectorUsesEventsByDefault()
        {
            $this->driverConnectorUsesEventsByDefault('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteConnectorUsesEventsByDefault()
        {
            $this->driverConnectorUsesEventsByDefault('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvConnectorUsesEventsByDefault()
        {
            $this->driverConnectorUsesEventsByDefault('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverConnectorUsesEventsByDefault($driver)
        {
            $connector = $this->getConnector($driver);

            $this->assertTrue($connector->usingEvents());
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlConnectorCanUnsetEvents()
        {
            $this->driverConnectorCanUnsetEvents('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlConnectorCanUnsetEvents()
        {
            $this->driverConnectorCanUnsetEvents('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteConnectorCanUnsetEvents()
        {
            $this->driverConnectorCanUnsetEvents('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvConnectorCanUnsetEvents()
        {
            $this->driverConnectorCanUnsetEvents('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverConnectorCanUnsetEvents($driver)
        {
            $connector = $this->getConnector($driver);

            $connector->unsetEventDispatcher();

            $this->assertFalse($connector->usingEvents());
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlReboundConnectorUsesPdoStub()
        {
            $this->driverReboundConnectorUsesPdoStub('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlReboundConnectorUsesPdoStub()
        {
            $this->driverReboundConnectorUsesPdoStub('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteReboundConnectorUsesPdoStub()
        {
            $this->driverReboundConnectorUsesPdoStub('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvReboundConnectorUsesPdoStub()
        {
            $this->driverReboundConnectorUsesPdoStub('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverReboundConnectorUsesPdoStub($driver)
        {
            $connector = $this->getPdoStubConnector($driver, false);

            $this->assertInstanceOf('MCDev\IlluminateConnectionEvents\Tests\Stubs\PdoStub', $connector->connect([]));
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlFiresConnectingEventWhenUsingEvents()
        {
            $this->driverFiresConnectingEventWhenUsingEvents('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlFiresConnectingEventWhenUsingEvents()
        {
            $this->driverFiresConnectingEventWhenUsingEvents('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteFiresConnectingEventWhenUsingEvents()
        {
            $this->driverFiresConnectingEventWhenUsingEvents('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvFiresConnectingEventWhenUsingEvents()
        {
            $this->driverFiresConnectingEventWhenUsingEvents('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverFiresConnectingEventWhenUsingEvents($driver)
        {
            if (!$this->app->bound('events')) {
                $this->markTestSkipped('The Illuminate Event Dispatcher is not available.');
            }

            $_SERVER['__event.test.DatabaseConnecting'] = false;
            $events = $this->app['events'];
            $events->listen(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting',
                function () {
                    $_SERVER['__event.test.DatabaseConnecting'] = true;
                }
            );

            $connector = $this->getPdoStubConnector($driver);
            $connector->connect(['name' => $driver]);
            $this->assertTrue($_SERVER['__event.test.DatabaseConnecting']);
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlFiresConnectedEventWhenUsingEvents()
        {
            $this->driverFiresConnectedEventWhenUsingEvents('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlFiresConnectedEventWhenUsingEvents()
        {
            $this->driverFiresConnectedEventWhenUsingEvents('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteFiresConnectedEventWhenUsingEvents()
        {
            $this->driverFiresConnectedEventWhenUsingEvents('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvFiresConnectedEventWhenUsingEvents()
        {
            $this->driverFiresConnectedEventWhenUsingEvents('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverFiresConnectedEventWhenUsingEvents($driver)
        {
            if (!$this->app->bound('events')) {
                $this->markTestSkipped('The Illuminate Event Dispatcher is not available.');
            }

            $_SERVER['__event.test.DatabaseConnected'] = false;
            $events = $this->app['events'];
            $events->listen(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnected',
                function () {
                    $_SERVER['__event.test.DatabaseConnected'] = true;
                }
            );

            $connector = $this->getPdoStubConnector($driver);

            $connector->connect(['name' => $driver]);

            $this->assertTrue($_SERVER['__event.test.DatabaseConnected']);
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlConnectingListenerCausesException()
        {
            $this->driverConnectingListenerCausesException('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlConnectingListenerCausesException()
        {
            $this->driverConnectingListenerCausesException('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteConnectingListenerCausesException()
        {
            $this->driverConnectingListenerCausesException('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvConnectingListenerCausesException()
        {
            $this->driverConnectingListenerCausesException('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverConnectingListenerCausesException($driver)
        {
            if (!$this->app->bound('events')) {
                $this->markTestSkipped('The Illuminate Event Dispatcher is not available.');
            }

            $events = $this->app['events'];
            $events->listen(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting',
                function () {
                    return false;
                }
            );

            $connector = $this->getPdoStubConnector($driver);

            $this->expectException('MCDev\IlluminateConnectionEvents\Exceptions\ConnectingException');

            $connector->connect(['name' => $driver]);
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlDoesntFireConnectingEventWhenNotUsingEvents()
        {
            $this->driverDoesntFireConnectingEventWhenNotUsingEvents('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlDoesntFireConnectingEventWhenNotUsingEvents()
        {
            $this->driverDoesntFireConnectingEventWhenNotUsingEvents('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteDoesntFireConnectingEventWhenNotUsingEvents()
        {
            $this->driverDoesntFireConnectingEventWhenNotUsingEvents('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvDoesntFireConnectingEventWhenNotUsingEvents()
        {
            $this->driverDoesntFireConnectingEventWhenNotUsingEvents('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverDoesntFireConnectingEventWhenNotUsingEvents($driver)
        {
            if (!$this->app->bound('events')) {
                $this->markTestSkipped('The Illuminate Event Dispatcher is not available.');
            }

            $_SERVER['__event.test.DatabaseConnecting'] = false;
            $events = $this->app['events'];
            $events->listen(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting',
                function () {
                    $_SERVER['__event.test.DatabaseConnecting'] = true;
                }
            );

            $connector = $this->getPdoStubConnector($driver);
            $connector->unsetEventDispatcher();
            $connector->connect(['name' => $driver]);

            $this->assertFalse($_SERVER['__event.test.DatabaseConnecting']);
        }

        /**
         * @throws BindingResolutionException
         */
        public function testMysqlDoesntFireConnectedEventWhenNotUsingEvents()
        {
            $this->driverDoesntFireConnectedEventWhenNotUsingEvents('mysql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testPgsqlDoesntFireConnectedEventWhenNotUsingEvents()
        {
            $this->driverDoesntFireConnectedEventWhenNotUsingEvents('pgsql');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqliteDoesntFireConnectedEventWhenNotUsingEvents()
        {
            $this->driverDoesntFireConnectedEventWhenNotUsingEvents('sqlite');
        }

        /**
         * @throws BindingResolutionException
         */
        public function testSqlsrvDoesntFireConnectedEventWhenNotUsingEvents()
        {
            $this->driverDoesntFireConnectedEventWhenNotUsingEvents('sqlsrv');
        }

        /**
         * @throws BindingResolutionException
         */
        public function driverDoesntFireConnectedEventWhenNotUsingEvents($driver)
        {
            if (!$this->app->bound('events')) {
                $this->markTestSkipped('The Illuminate Event Dispatcher is not available.');
            }

            $_SERVER['__event.test.DatabaseConnected'] = false;
            $events = $this->app['events'];
            $events->listen(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnected',
                function () {
                    $_SERVER['__event.test.DatabaseConnected'] = true;
                }
            );

            $connector = $this->getPdoStubConnector($driver);
            $connector->unsetEventDispatcher();
            $connector->connect(['name' => $driver]);

            $this->assertFalse($_SERVER['__event.test.DatabaseConnected']);
        }
    }
}
