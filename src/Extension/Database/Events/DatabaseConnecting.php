<?php
namespace MCDev\IlluminateConnectionEvents\Extension\Database\Events;

use Illuminate\Database\Connectors\Connector;
use MCDev\IlluminateConnectionEvents\Traits\ConnectorConnectTrait;

class DatabaseConnecting extends ConnectorEvent
{
    /**
     * The config array used to connect to the database.
     *
     * @var array
     */
    public $config;

    /**
     * Create a new event instance.
     *
     * @param Connector|ConnectorConnectTrait $connector
     * @param string $name
     * @param array  &$config
     */
    public function __construct($connector, string $name, array &$config)
    {
        parent::__construct($connector, $name);

        $this->config = &$config;
    }
}
