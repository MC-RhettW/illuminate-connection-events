<?php
namespace MCDev\IlluminateConnectionEvents\Extension\Database\Connectors;

use Illuminate\Database\Connectors\PostgresConnector as BasePostgresConnector;
use MCDev\IlluminateConnectionEvents\Traits\ConnectorConnectTrait;

class PostgresConnector extends BasePostgresConnector
{
    use ConnectorConnectTrait;
}
