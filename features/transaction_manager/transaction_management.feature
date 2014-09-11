@transaction
Feature: Transaction Management
  As an application
  I need to perform transactions against the Neo4j graph db
  The Transaction Manager can take care of it

  Responsibilities

  The Transaction Manager should handle the process of commiting queue statements
  to the neo4j rest api.
  The Transaction receives the Connection settings and is bounded to an HTTP Client

  He will first ask the Queue to transform the statements into a json object.
  He will then configure the Request object that he will pass to the HTTP Client

  Once the result received from the HttpClient, he will make sure the transaction is closed
  and return the result to the NeoKernel

  Scenario: Accessing the Transaction Manager
    Given there is a default configuration
    And the application run
    When I ask for the Transaction Manager
    Then I should be able to list the opened transactions