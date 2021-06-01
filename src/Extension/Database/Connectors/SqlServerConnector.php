<?php
namespace MCDev\IlluminateConnectionEvents\Extension\Database\Connectors;

use Illuminate\Database\Connectors\SqlServerConnector as BaseSqlServerConnector;
use MCDev\IlluminateConnectionEvents\Traits\ConnectorConnectTrait;

class SqlServerConnector extends BaseSqlServerConnector
{
    use ConnectorConnectTrait;
}
