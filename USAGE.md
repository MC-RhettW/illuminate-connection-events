# Usage

### DatabaseConnecting Event

The `MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting` event allows you to hook into the
database connection lifecycle before the connection is established. Additionally, this event provides you the ability to
modify the configuration used for the connection, as well as completely cancel the connection attempt.

**Attributes**

The `DatabaseConnecting` event provides three public attributes:

|Attribute|Description|
|---------|-----------|
|`public $connector`|The `Connector` object making the connection. This package extends each of the built-in connectors.|
|`public $connectionName`|The name of the selected database connection configuration.|
|`public $config`|The configuration array used to connect to the database.|

Example:

```php
app('events')->listen('MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting', function ($event) {
    app('log')->info('Connector class: '.get_class($event->connector));
    app('log')->info('Connection name: '.$event->connectionName);
    app('log')->info('Configuration: '.print_r($event->config, true));
});
```

**Modifying Connection Configuration**

The configuration for your database connections is usually stored in your `config/database.php` file (in conjunction
with your `.env` file). If, however, you need to dynamically modify the configuration used for the connection, this can
be done inside a `DatabaseConnecting` event listener. Any changes made to the configuration in the event listener will
be used for the database connection.

Example:

```php
app('events')->listen('MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting', function ($event) {
    // don't connect to mysql in strict mode if you like zeroed out dates
    if (i_like_zero_dates()) {
        $event->config['strict'] = false;
    }
});
```

**Cancelling the Connection**

There may be situations where you would like to prevent the database from attempting the connection. In this case, the
database connection attempt can be cancelled by returning `false` from a `DatabaseConnecting` event listener. If the
database connection is cancelled, a `MCDev\IlluminateConnectionEvents\Exceptions\ConnectingException` runtime exception
will be thrown.

Example:

```php
app('events')->listen('MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnecting', function ($event) {
    if (not_todaaay()) {
        return false;
    }
});
```

### DatabaseConnected Event

The `MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnected` event allows you to hook into the
database connection lifecycle after the connection is established. Additionally, this event provides access to the final
configuration used for the connection, as well as the connection itself.

**Attributes**

The `DatabaseConnected` event provides four public attributes:

|Attribute|Description|
|---------|-----------|
|`public $connector`|The `Connector` object making the connection. This package extends each of the built-in connectors.|
|`public $connectionName`|The name of the selected database connection configuration.|
|`public $config`|The configuration array that was used to connect to the database.|
|`public $pdo`|The connected `PDO` (or potentially `Doctrine\DBAL\Driver\PDOConnection`, as of 5.3) object.|

Example:

```php
app('events')->listen('MCDev\IlluminateConnectionEvents\Extension\Database\Events\DatabaseConnected', function ($event) {
    app('log')->info('Connector class: '.get_class($event->connector));
    app('log')->info('Connection name: '.$event->connectionName);
    app('log')->info('Configuration: '.print_r($event->config, true));
    app('log')->info('PDO class: '.get_class($event->pdo));
});
```
