@connection
Feature: Manage multiple DB Connections
  As a developer
  When working with multiple databases
  I want a Connection Management to switch between them

  Scenario: Accessing the connection manager
    Given There is a default config file present
    When I access the connection manager
    Then I should be able to get the default connection

  Scenario: Choosing between multiple connections
    Given There is a multiple connections configuration
    When I access the connection manager
    Then I can choose the "default" connection
    And I can choose the "custom" connection