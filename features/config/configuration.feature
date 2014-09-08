@config
Feature: Configuration Handling and Validation
  As an Application
  In order to load and validate a configuration file
  I need a loading and validating system

  Scenario: Loading the configuration file
    Given there is a "neoconnect.yml" default config file present at the root of the project
    When I load and parse the configuration
    Then I should have an array equal to the default configuration

  Scenario: Validating the configuration file
    Given there is a "neoconnect.yml" default config file present at the root of the project
    When I load and parse the configuration
    And I validate it
    Then I should have a valid configuration

  Scenario: Validating an invalid configuration file
    Given there is a "neoconnect.yml" default config file present at the root of the project
    When I load and parse the configuration
    And I replace the "connections" key by the "azerty" key
    Then I should have an invalid configuration error

