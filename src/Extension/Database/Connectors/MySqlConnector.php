<?php
namespace MCDev\IlluminateConnectionEvents\Extension\Database\Connectors;

use Illuminate\Database\Connectors\MySqlConnector as BaseMySqlConnector;
use MCDev\IlluminateConnectionEvents\Traits\ConnectorConnectTrait;

class MySqlConnector extends BaseMySqlConnector
{
    use ConnectorConnectTrait;
}
