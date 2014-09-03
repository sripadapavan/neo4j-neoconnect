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
        "neoxygen/neoconnect" : "~0.4.*@dev"
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

Or you maybe want to put your configuration in a `Yaml` file :

```yaml
#/Users/kwattro/my_app/config/neoconnect_config.yml
connection:
  host: 192.168.56.101
  port: 7474
```

```php
$file = '/Users/kwattro/my_app/config/neoconnect_config.yml';

$connection = ConnectionBuilder::create()
              ->loadConfigurationFromFile($file)
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

### Commit Strategies

When sending Cypher queries, it creates a statement object for each query and add it to a `StatementStack`.

For each sendCypherQuery method call, the `TransactionManager` will call the xxxCommitStrategy class to determine
if the stack should be commited or not.

The library is currently shipped with two simple Commit Strategies, respectively `Auto` and `Stack`.

The `AutoCommitStrategy` will commit the stack after each `sendCypherQuery` call. This is the default commit strategy.

The `StackCommitStrategy` will empile the statements into the stack and wait that a statement contains a flushTrigger,
if the trigger is found, the TransactionManager will commit the stack of statements.

You can configure the stack mode when providing the configuration in the Connection Building setup :

```php
$conn = ConnectionBuilder::create()
        ->loadConfiguration($config)
        ->build();
```

Or with a YAML file :

```yaml
connection: ~
transaction:
  commit_strategy:
    strategy: stack
```

To add a `flushTrigger` to a statement, simply add a 3rd argument to the `sendCypherQuery` method :

```php
$query1 = 'MATCH (n:MyLabel) RETURN n';
$conn->sendCypherQuery($query1);
$query2 = 'MATCH (n:MyOtherLabel) RETURN n';
$conn->sendCypherQuery($query2, null, true) // <- 2nd argument is for parameters, 3rd is to set the flushTrigger
```

There is also a convenience method `addCypherQuery` when working in stack mode.

By analysing the logs, you can have an idea of the whole process :

```
[2014-09-02 11:31:29] neoconnect.DEBUG: Processing Root Endpoint Discovery [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Request sent in 0.010097026824951 seconds [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Root Endpoint Discovery Completed [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Processing Mangement Endpoint Discovery [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Request sent in 0.0019969940185547 seconds [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Management Endpoint Discovery Completed [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Processing Data Endpoint Discovery [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Request sent in 0.0017061233520508 seconds [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Data Endpoint Discovery Completed [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Query added to stack {"query":"MATCH (n:Coool {id: {props}.id }) RETURN n","parameters":{"props":{"id":1409225696}}} []
[2014-09-02 11:31:29] neoconnect.DEBUG: Verifying if the Stack should be flushed [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Calling the Stack Commit Strategy [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: No FlushTrigger found [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Query added to stack {"query":"MATCH (n) RETURN count(n)","parameters":[]} []
[2014-09-02 11:31:29] neoconnect.DEBUG: Verifying if the Stack should be flushed [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: Calling the Stack Commit Strategy [] []
[2014-09-02 11:31:29] neoconnect.DEBUG: FlushTrigger found [] []
[2014-09-02 11:31:29] neoconnect.INFO: Stack Flush Init - Flushing 2 statement(s) [] []
[2014-09-02 11:31:30] neoconnect.DEBUG: Request sent in 0.81385016441345 seconds [] []
[2014-09-02 11:31:30] neoconnect.INFO: Stack Flush Completed [] []
```

Adding your custom `CommitStrategy` is on the roadmap.

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

### Registering Event Subscribers

You can register your own EventSubscribers to hook in the `NeoConnect` Event System.

1. Create your CustomEventSubscriberClass, this class should extend `Neoxygen\NeoConnect\EventSubscriber\BaseEventSubscriber`
and implement the public static function `getSubscribedEvents`

You may for example want to ensure that a statement contains always a `graph` result data content and you also want
to replace all create clauses by the merge clauses (this is an example :) )

By hooking the `PRE_QUERY_ADD_TO_STACK` Event, you can have access to the statement and modify it :

```php
namespace Acme\EventSubscriber\MyEventSubscriber;

use Neoxygen\NeoConnect\EventSubscriber\BaseEventSubscriber,
    Neoxygen\NeoConnect\Event\PreQueryAddToStackEvent;

class CustomEventSubscriber extends BaseEventSubscriber

    public static function getSubscribedEvents()
    {
        return array(
            'pre.query_add_to_stack' => array(
                array('verifyGraphResultDataContentIsSet', 20),
                array('replaceCreateByMerge', 10)
            )
        );
    }

    public function verifyGraphResultDataContentIsSet(PreQueryAddedToStackEvent $event)
    {
        $statement = $event->getStatement();
        if (!in_array('graph', $statement->getResultDataContents())) {
            $result = $statement->getResultDataContents();
            array_push($result, 'graph');
            $statement->setResultDataContents($result);

        }
    }

    public function replaceCreateByMerge(PreQueryAddedToStackEvent $event)
    {
        $statement = $event->getStatement();
        $q = $statement->getStatement();
        $newQuery = str_replace('CREATE', 'MERGE', $q);
        $statement->setStatement($newQuery);
    }
```

You can now register this subscriber when building your connection :

```php
use Acme\EventSubscriber\CustomEventSubscriber;
use Neoxygen\NeoConnect\ConnectionBuilder;

$myCustomSubscriber = new CustomEventSubscriber();
$connection = ConnectionBuilder::create()
              ->addEventSubscriber($myCustomSubscriber)
              ->build();

```

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
