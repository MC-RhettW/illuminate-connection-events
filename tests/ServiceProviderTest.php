<?php /** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

namespace MCDev\IlluminateConnectionEvents\Tests {

    use Illuminate\Contracts\Container\BindingResolutionException;

    class ServiceProviderTest extends TestCase
    {

        public function testMysqlConnectorBound()
        {
            $this->assertTrue($this->app->bound('db.connector.mysql'));
        }

        public function testPgsqlConnectorBound()
        {
            $this->assertTrue($this->app->bound('db.connector.pgsql'));
        }

        public function testSqliteConnectorBound()
        {
            $this->assertTrue($this->app->bound('db.connector.sqlite'));
        }

        public function testSqlsrvConnectorBound()
        {
            $this->assertTrue($this->app->bound('db.connector.sqlsrv'));
        }

        /**
         * @throws BindingResolutionException
         */
        public function testContainerMakesExtendedMysqlConnector()
        {
            $connector = $this->getConnector('mysql');

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\MySqlConnector',
                $connector
            );
        }

        /**
         * @throws BindingResolutionException
         */
        public function testContainerMakesExtendedPgsqlConnector()
        {
            $connector = $this->getConnector('pgsql');

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\PostgresConnector',
                $connector
            );
        }

        /**
         * @throws BindingResolutionException
         */
        public function testContainerMakesExtendedSqliteConnector()
        {
            $connector = $this->getConnector('sqlite');

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\SQLiteConnector',
                $connector
            );
        }

        /**
         * @throws BindingResolutionException
         */
        public function testContainerMakesExtendedSqlsrvConnector()
        {
            $connector = $this->getConnector('sqlsrv');

            $this->assertInstanceOf(
                'MCDev\IlluminateConnectionEvents\Extension\Database\Connectors\SqlServerConnector',
                $connector
            );
        }
    }
}
