@container
Feature: Managing Services and Dependencies with a Service Container
  As an Application
  In order to manage multiple services and dependencies in an efficient way
  I should use a Service Container

  Scenario: Building the Container
    Given there is a default configuration
    When the application run
    Then it should create a Service Container

  Scenario: Adding the connection manager
    Given there is a default configuration
    When the application run
    Then I should have access to the connection manager

  Scenario: Accessing the default connection
    Given there is a default configuration
    When the application run
    Then I should have access to the default connection
    And the connection parameters should be:
    | parameter      | value     |
    | scheme         | http      |
    | host           | localhost |
    | port           | 7474      |
    And the flush strategy should be "manual_flush"
    And the authentication mode should be disabled

  Scenario: Flush strategies should be registered for the default connection
    Given there is a default configuration
    When the application run
    Then there should be a "neoconnect.flush_strategy.default" service
    And there should be a "default.flush_strategy" service alias

  Scenario: An EventDispatcher should be registered
    Given there is a default configuration
    When the application run
    Then there should be an event dispatcher available