# features/createDB.feature
Feature: createDB
	In order to use different objects
	from the Database,
	I need to have one created.
	
Scenario: create the Database
  Given PdoSql extension is loaded
  When I run the route to create my database 
  Then I should have a database created
