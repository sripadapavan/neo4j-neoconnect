@queue
Feature: Queue Management
  As an application
  When working with multiple connections
  I should assign query statements to a connection statements queue
  There is the role of the queue manager
  The Queue manager will create and hold queues for each connection
  When he receive a statement, he add it to the corresponding queue
  And then he returns the queue back to the NeoKernel

  Scenario: The Queue Manager is accessible as service
    Given there is a default configuration
    And the application run
    When I ask the Queue Manager Service
    Then I should be able to access queues

  Scenario: The Queue Manager receive a statement
    Given there is a default configuration
    And the application run
    When the Queue Manager receive a statement
    Then he should add it to the "default" queue

  Scenario: Multiple connections
    Given there is a multiple connections configuration
    And the application run
    When the Queue Manager receive a statement for the "default" connection
    Then he should add it to the "default" queue

  Scenario: Multiple Connections, statement for connection two
    Given there is a multiple connections configuration
    And the application run
    When the Queue Manager receive a statement for the "connection2" connection
    The he should add it to the "connection2" queue
