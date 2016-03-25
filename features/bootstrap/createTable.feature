# features/createTable.feature
Feature: createTable
	In order to use the database, 
	2 tables should have been created

	
Scenario: create the 2 tables
  Given The database is already created
  When I run the fixture to create my tables 
  Then I should have my two tables
