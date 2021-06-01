<?php /** @noinspection PhpUndefinedMethodInspection */

namespace MCDev\IlluminateConnectionEvents\Tests {

    use Illuminate\Config\Repository;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Foundation\Application;
    use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
    use MCDev\IlluminateConnectionEvents\Tests\Stubs\PdoStub;
    use Mockery as m;
    use ReflectionException;
    use ReflectionMethod;

    class TestCase extends BaseTestCase
    {
        public function createApplication()
        {
            $app = new Application();
            $app->register('Illuminate\Database\DatabaseServiceProvider');
            $app->register('MCDev\IlluminateConnectionEvents\LaravelDbEventsServiceProvider');

            $app->instance('config', new Repository([]));

            $app['config']['database'] = [
                'default' => 'valid',
                'connections' => [
                    'valid' => [
                        'driver' => 'sqlite',
                        'database' => ':memory:',
                    ],
                    'invalid' => [
                        'driver' => 'sqlite',
                        'database' => 'memory',
                    ],
                ],
            ];

            return $app;
        }

        protected function getConnection($connection = null)
        {
            return $this->app['db']->connection($connection);
        }

        /**
         * @throws BindingResolutionException
         */
        protected function getConnector($driver)
        {
            return $this->app->make('db.connector.' . $driver);
        }

        protected function getDbFactoryConnector($driver)
        {
            return $this->app['db.factory']->createConnector(['driver' => $driver]);
        }

        /**
         * @throws BindingResolutionException
         */
        protected function bindMockedConnector($driver)
        {
            $original = $this->getConnector($driver);

            $this->app->bind('db.connector.' . $driver, function () use ($original) {
                $connector = m::mock(get_class($original))->shouldAllowMockingProtectedMethods()->makePartial();
                if ($original->usingEvents()) {
                    $connector->setEventDispatcher($original->getEventDispatcher());
                }

                return $connector;
            });
        }

        /**
         * @throws BindingResolutionException
         */
        protected function getMockedConnector($driver, $withEvents = true)
        {
            $this->bindMockedConnector($driver);
            $connector = $this->getConnector($driver);
            if ($withEvents && !$connector->usingEvents() && $this->app->bound('events')) {
                $connector->setEventDispatcher($this->app['events']);
            }

            return $connector;
        }

        /**
         * @throws BindingResolutionException
         */
        protected function getPdoStubConnector($driver, $withEvents = true)
        {
            $connector = $this->getMockedConnector($driver, $withEvents);
            $connector->shouldReceive('parentConnect')->andReturn(new PdoStub());

            return $connector;
        }

        /**
         * @throws ReflectionException
         */
        protected function callRestrictedMethod($object, $method, array $args = [])
        {
            $reflectionMethod = new ReflectionMethod($object, $method);
            $reflectionMethod->setAccessible(true);

            return $reflectionMethod->invokeArgs($object, $args);
        }
    }
}
