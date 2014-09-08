@statement
Feature: Query encapsulation into a Statement Object
  As a developer
  I want my cypher queries to be encapsulated into statement objects
  So I can manage them in a nice OO way

  Scenario: Creating a statement without parameters
    Given I send a simple match query
    And my query does not contain parameters
    Then it should create a Statement object
    And the Statement should not contain parameters

  Scenario: Creating a statement with parameters
    Given I send a simple match query
    And I provide the following parameters:
    | key  | value    |
    | name | michel   |
    | city | brussels |
    When I ask the StatementManager to create the statement
    Then it should create a Statement object
    And the Statement should contain parameters