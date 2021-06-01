# Illuminate DB Connection Events

A support package that extends Illuminate Database package with pre/post connection events.

This package is a downstream copy of [laravel-db-events](https://github.com/shiftonelabs/laravel-db-events)
by [Patrick Carlo-Hickman](https://github.com/patrickcarlohickman) forked for direct maintenance and forward support for
Laravel 7 and later.

## Overview

This library provides:

***Events***

- `DatabaseConnecting`: fired before connecting to the database
- `DatabaseConnected`: fired after connecting to the database

***Exceptions***

- `ConnectingException`: thrown if the database connection is cancelled during `DatabaseConnecting`

See [USAGE](USAGE.md) for additional information and examples.

## Installation

Add the private repository to the `repositories` block of your Laravel project's composer.json file:

```json
{
  "repositories": [{
      "name":   "mcdev/illuminate-connection-events",
      "type":   "vcs",
      "url":    "https://github.com/MC-RhettW/illuminate-connection-events.git"
    }]
}
```

Then add the package to the `require-dev` block:

```json
{
  "require": {
    "mcdev/illuminate-connection-events": ">=1.0.1"
  }
}
```

## Security

Please see [SECURITY](SECURITY.md) for important security support information.

## License

The MIT License (MIT). Please see [License File](LICENSE.txt) for more information.
