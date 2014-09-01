# NeoConnect
## Full-featured and flexible Neo4j ReST API Client for PHP

[![Build Status](https://travis-ci.org/neoxygen/neo4j-neoconnect.svg?branch=master)](https://travis-ci.org/neoxygen/neo4j-neoconnect)
[![Total Downloads](https://poser.pugx.org/neoxygen/neoconnect/downloads.svg)](https://packagist.org/packages/neoxygen/neoconnect)
[![Latest Unstable Version](https://poser.pugx.org/neoxygen/neoconnect/v/unstable.svg)](https://packagist.org/packages/neoxygen/neoconnect)
[![Coverage Status](https://img.shields.io/coveralls/neoxygen/neo4j-neoconnect.svg)](https://coveralls.io/r/neoxygen/neo4j-neoconnect)
[![License](https://poser.pugx.org/neoxygen/neoconnect/license.svg)](https://packagist.org/packages/neoxygen/neoconnect)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/7e3062b3-4508-46a4-8018-cec2e62a7a62/big.png)](https://insight.sensiolabs.com/projects/7e3062b3-4508-46a4-8018-cec2e62a7a62)

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
        "neoxygen/neoconnect" : "~0.3.*@dev"
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

### Sending a Cypher Query

You can send easily a Cypher Query through the connection :

```php
$query = 'MATCH (n) RETURN count(n)';
$result = $connection->sendCypherQuery($query);
```

or with query parameters :

```php
$query = 'MATCH (n:MyLabel { id: {props.id} }) RETURN n';
$params = array('props' => array('id' => 1234));

$result = $connection->sendCypherQuery($query, $params);
```

### Api Discovery

NeoConnect client is built with discoverability in mind, this means that starting from the API root endpoint, the client
will discover the whole API by making GET requests, so if the API changes its URI scheme, the library will not break.

You can have access to the endpoints through the API Discovery Service :

```php
$api = $connection->getApiDiscovery();
$labelsEndpoint = $api->getDataEndpoint()->getLabels(); // http://localhost:7474/db/data/labels
$transactionEndpoint = $api->getDataEndpoint()->getTransaction(); // http://localhost:7474/db/data/transaction
```


### Deserializer

Responses from the ReST API are deserialized to PHP model classes, you can find them in the `Deserializer` folder.
This gives the possibility to work with responses in an OOP manner.

### Transaction Settings

Transactions settings are on the roadmap. The following functionnalities are planned :

* Manual Building, RollBack, Commits
* Multiple Statements in one transaction
* Parallel HTTP Requests ?

### Events

`NeoConnect` dispatches a lot of events during the process, you can add event listeners or subscribers to these events.

For a complete list of the dispatched Events, take a look at the `Neoxygen\NeoConnect\NeoConnectEvents` class.

### Logging

The library has a Special `LoggingEventSubscriber` that will listen and log all events relating to the usage of the database.

You can register your own logging system to benefit from the logging events.

For e.g. using Monolog as a Logging Interface :

```php
use Monolog\Logger,
    Monolog\Handler\StreamHandler;
use Neoxygen\NeoConnect\ConnectionBuilder;

$log = new Logger('my_logger');
$handler = new StreamHandler('/path/to/my/log/file.log', Logger::DEBUG);
$log->pushHandler($handler);

// Building the connection and registering the logger :
$conn = ConnectionBuilder::create()
        ->registerLogger($log)
        ->build();
```

You will now have a full debug logging to your system with request times ;-)

### Debug Mode

To be written

### CLI

```
php bin/neoconnect config:dump
```

! Should be moved to a dedicated package

### Configuration Reference

To be written

### Tests

PHPSpec, Behat, PHPUnit

### License

MIT License
