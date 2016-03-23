# features/createDB.feature
Feature: webServerStarted
	In order to all other test, we need to have our web server started.
	
Scenario: start the web server
  Given The web server is started
  Then I shoud have a web server started
