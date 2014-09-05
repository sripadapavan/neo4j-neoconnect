@config
Feature: Generating a configuration file
  As a developer
  In order to configure my connection
  I want that the config file is generated for me

  Scenario: Generating the config file with the console
    Given There is no config file present
    When I run the "config:generate" command
    Then the config file should be generated