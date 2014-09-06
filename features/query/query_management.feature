@query_management
Feature: Query Management
  As a developer
  I want an efficient and configurable way to mangage how my queries
  are handled and commited

  Scenario: Basic Query sending
    Given The application is bootstrapped with default config
    When I send "1" basic match queries
    And I commit
    Then I should have "1" query results in json format

  Scenario: Sending multiple queries and commit
    Given The application is bootstrapped with default config
    When I send "2" basic match queries
    Then I should have "2" query results in json format