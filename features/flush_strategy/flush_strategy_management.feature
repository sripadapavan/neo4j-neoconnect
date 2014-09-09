@flush_strategy
Feature: Flush Strategy Management
  As an application
  In order to have flush strategy management for each connection
  I should have a Flush Manager that determine the flush strategy
  to use for each connection.
  This manager will receive a queue of statements and the connection,
  He will then call the corresponding flush strategy service to
  determine if the queue should be flushed or not.
  Read FSM as Flush Strategy Manager

  Scenario: Flush Strategy Manager is available as service
    Given there is a default configuration
    And the application run
    When I call the Flush Strategy Service
    Then I should have a access to my strategies

  Scenario: FSM receives a queue
    Given there is a default configuration
    And the application run
    When the FSM receives a queue for the default connection
    Then he should return the queue without flush decision