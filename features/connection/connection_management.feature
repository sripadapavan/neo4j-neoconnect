@connection
Feature: Manage multiple DB Connections
  As a developer
  I need to work with multiple graph databases
  So I want a Connection Management to switch between them

  Scenario: Accessing the connection manager
    Given There is a default config file present
    When I access the connection manager
    Then I should be able to get the default connection

  Scenario: Choosing between multiple connections
    Given There is a multiple connections configuration
    When I access the connection manager
    Then I can choose the "default" connection
    And I can choose the "custom" connection

  Scenario: Getting the default connection when in multiple connections config
    Given There is a multiple connections configuration
    When I ask a connection without specifying the alias
    Then I should get the default connection

  Scenario: Asking a non existent connection
    Given There is a multiple connections configuration
    When I ask the "rumblebee" connection
    Then I should have an invalid connection error