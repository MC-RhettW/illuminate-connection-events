<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

/** @noinspection ALL */

namespace MCDev\IlluminateConnectionEvents\Traits;

use Illuminate\Support\Arr;
use MCDev\IlluminateConnectionEvents\Exceptions\ConnectingException;
use MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnected;
use MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting;
use PDO;

trait ConnectorConnectTrait
{
    use SupportsEvents;

    /**
     * Establish a database connection.
     *
     * @param array $config
     * @return PDO
     */
    public function connect(array $config): PDO
    {
        if ($this->fireEvent(new DatabaseConnecting($this, Arr::get($config, 'name'), $config), true) === false) {
            throw new ConnectingException();
        }

        $connection = $this->parentConnect($config);

        $this->fireEvent(new DatabaseConnected($this, Arr::get($config, 'name'), $config, $connection));

        return $connection;
    }

    /**
     * Call connect on the parent class to establish a database connection.
     *
     * @param array $config
     * @return PDO
     */
    protected function parentConnect(array $config): PDO
    {
        return parent::connect($config);
    }
}
