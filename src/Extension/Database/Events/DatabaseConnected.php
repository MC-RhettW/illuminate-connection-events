<?php
namespace MCDev\IlluminateConnectionEvents\Extension\Database\Events;

use Illuminate\Database\Connectors\Connector;
use MCDev\IlluminateConnectionEvents\Traits\ConnectorConnectTrait;
use PDO;

class DatabaseConnected extends ConnectorEvent
{
    /**
     * The config array used to connect to the database.
     *
     * @var array
     */
    public $config;

    /**
     * The connected PDO connection.
     *
     * @var PDO
     */
    public $pdo;

    /**
     * Create a new event instance.
     *
     * @param Connector|ConnectorConnectTrait $connector
     * @param string $name
     * @param array $config
     * @param PDO $pdo
     */
    public function __construct($connector, string $name, array $config, PDO $pdo)
    {
        parent::__construct($connector, $name);

        $this->config = $config;
        $this->pdo = $pdo;
    }
}
