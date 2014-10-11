# NeoConnect - WIP

## Leveraging NeoClient

### Introduction

`NeoConnect` is an http client written in PHP that wraps the [Neo4j Graph Database](https://neo4j.org) ReST API.

The library has the following features :

- Multiple databases support
- Api Discovery
- Flush Strategies
- Fully configurable
- Handy result format
- Built-in Events & Logging system
- ...

### Installation

You only need to add the dependency in your `composer.json` file :

```json
{
    "require": {
        "neoxygen/neoconnect": "~0.7"
    },
    // if you want to have the cli tools available in the bin dir of your project root folder
    // add the following lines
    "config": {
        "bin-dir": "bin"
    }
}
```

and run the `composer update neoxygen/neoconnect` command.

### Configuring your connection(s)

You need to create a `neoconnect.yml` file at the root of your project where you'll define the settings of the library.

A handy CLI tool can generate this file for you, just run the following command :

```bash
bin/neo config:generate
```

Adapt the connection settings in the file, if you're using the standard Neo4j server settings (http, localhost, 7474, noauth),
you're ready to go for the next step)

### Bootstrap the library in your application

Supposing you're using composer, just require the autoloader and bootstrap the library based on your configuration file :

```php
<?php

require_once 'vendor/autoload.php';

use NeoConnect\Neo;

Neo::getServiceContainer()
    ->loadConfiguration(__DIR__.'/neoconnect.yml)
    ->build();
```

That's it !

### Basic usage

#### Sending Cypher Queries

```php
$query = 'MATCH (n)-[:WORKS_AT]->(c:Company {props})';
$parameters = array(
    'props' => array(
        'name' => 'Awesome Company'
        )
    );

Neo::sendQuery($query, $parameters);

$result = Neo::flush();
```

The plain query and the parameters array will begin now their journey in the earth of `NeoConnect`.

### The query lifecycle

Starting from the plain query to the result, the query will have to do a funny journey inside the `NeoConnect` kernel.

The NeoConnect Kernel is an event based system that will dispatch events depending of the state of the query :

#### First step : Transformation into a Statement object

The `NeoKernel` will dispatch a special Event to say that the query needs to be encapsulated in a Statement object.

The StatementManager takes care of this Event and the Transformation, the Statement object is then returned back to the NeoKernel.

#### Second step : Adding the statement to a Queue

Another Event is then dispatched, saying that the Statement should be added to a `Queue` of statements.

The `QueueManager` have the responsibilty to create one queue per database, and add statements to the corresponding queue,
while when working with one and only one database this feature is not really necessary, this is a requirement when working
with multiple databases.

Once the Queue is created and the Statement added to it, she's returned back to the `NeoKernel`.

#### Third Step : Introducing Flush Strategies

By default ( See the [Flush Strategies](#flush-strategies) section for more details ) you'll have to call implicitly the flush
call to trigger the transaction into the datbase, this means that the statements are encapsulated into the Queue and they
will be comitted in one transaction when triggering the `flush` call.

You can configure the strategy to use for each connection ( for e.g. you may want to automatically flush for your usage statistics
database but not for your products catalog website ).

So what will happen ?

The Queue will be handled by the `FlushStrategyManager`, he knows what strategy to perform on the Queue based on the connection
settings. He will call the strategy corresponding to the Queue asking if the queue should be flushed or not.

The `FlushStrategyDecision` and the Queue are transmitted back to the NeoKernel.

There is a dedicated documentation section to learn how implement your own `FlushStrategy`.

#### Fourth step : Flushing or not Flushing ?

Based on the `FlushStrategyDecision`, the `NeoKernel` has now two options :

1. The Queue should not be flushed : Then the Queue is returned to the user.

2. The Queue should be flushed : The Queue is passed to the TransactionManager that will perform the Commit transaction
   and return you the Response.

If you want to know how much Statements your Queue contains, just call `Neo::getQueueCount();` or
`Neo::getQueueCount('myConnectionAlias');`.


---

### (:You)-[:USE]->(:NeoConnect) ?

Propositions, remarks, PR's, ... are always welcome.

### Tests

The library has been made entirerly in BDD using Behat & PHPSpec.

To run the test suite, just initiate these two commands :

```bash
vendor/bin/beheat
vendor/bin/phpspec run -fpretty
```

### License & Info

The library is released under the MIT License. For more informations view the LICENSE file that is bundled with the library.

Author : [Christophe Willemsen](https://twitter.com/ikwattro) ping me at willemsen.christophe @ gmail.com



