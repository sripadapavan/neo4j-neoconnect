# NeoConnect
## Full-featured and flexible Neo4j ReST API Client for PHP

### Foreword

This library aims to provide a powerful Neo4j api client. Following features are included :

* Api Discovery
* Dependency Injection
* Event Dispatching
* Fully configurable
* CLI Tools
* Json Response Deserializing

### Installation :

Installation can be done through composer :

```json
{
    "require": {
        "neoxygen/neoconnect" : "~0.1.*@dev"
    },
    "minimum-stability" : "dev",
    "config": {
        "bin-dir": "bin"
    }
}
```

### Usage

Ideally this would be done through dependency injection. Otherwise:

You can build a ```connection``` to the Neo4j databse by calling the static create&build functions :

```php
require_once 'vendor/autoload.php';

use Neoxygen\NeoConnect\ConnectionBuilder;

$connection = ConnectionBuilder::create()->build();
```

This will create and compile a service container referencing all the available services and configuration.

You can add additional configuration settings while creating your connection :

```php
$config = array(
    'connection' => array(
           'host' => '192.168.2.13',
           'port' => 7475
           )
       );
$connection = ConnectionBuilder::create()
                ->loadConfiguration($config)
                ->build();
```

### Api Discovery

### Deserializer

### Transaction Settings

### Events

### Logging

### Debug Mode

### CLI

```
php bin/neoconnect config:dump
```

### Configuration Reference

### Tests

### License