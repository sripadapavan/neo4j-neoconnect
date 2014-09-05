@config
Feature: First step with the console
  As a developer
  In order to know what I can do with the console
  I want the console to show me the available commands

  Scenario: Executing neoconnect to list the available commands
    Given I am on the root directory of my project
    When I execute the neoconnect command
    Then I should be presented the Console help message
