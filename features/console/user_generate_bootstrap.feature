@config
Feature: Generating the bootstrap of the application config
  As a developer
  Once my configuration file is set up
  I want a automated way to load this configuration and get access to my db connection

  Scenario: Generating the bootstrap file
    Given There is a config file present
    And my configuration is the default config
    When I excecute the "config:bootstrap" command
    Then I should have a bootstrap file generated