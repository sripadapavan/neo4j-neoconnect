@config
Feature: Checking the configuration file
  As a developer
  In order to know if my configuration is valid
  I want to check it with one cli line

  Scenario: Running the config:check command
    Given There is a config file present
    And my configuration is the default config
    When I check the config with the cli
    Then there should be no errors

  Scenario: Running the config:check command with an invalid config
    Given There is a config file present
    And my configuration is invalid
    When I run the configcheck command
    Then I should see an error message