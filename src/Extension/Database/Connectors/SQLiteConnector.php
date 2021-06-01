<?php
namespace MCDev\IlluminateConnectionEvents\Extension\Database\Connectors;

use Illuminate\Database\Connectors\SQLiteConnector as BaseSQLiteConnector;
use MCDev\IlluminateConnectionEvents\Traits\ConnectorConnectTrait;

class SQLiteConnector extends BaseSQLiteConnector
{
    use ConnectorConnectTrait;
}
