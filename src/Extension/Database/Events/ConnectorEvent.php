<?php
namespace MCDev\IlluminateConnectionEvents\Extension\Database\Events;

use Illuminate\Database\Connectors\Connector;

abstract class ConnectorEvent
{
    /**
     * The database connector instance.
     *
     * @var Connector
     */
    public $connector;

    /**
     * The name of the connection.
     *
     * @var string
     */
    public $connectionName;

    /**
     * Create a new event instance.
     *
     * @param Connector $connector
     * @param string $name
     */
    public function __construct(Connector $connector, string $name)
    {
        $this->connector = $connector;
        $this->connectionName = $name;
    }
}
