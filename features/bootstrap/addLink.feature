# features/addLink.feature
Feature: addLink
	In order to do this project,
	we need to add links by Url.
	
	
Scenario: add a link
  Given a url for the link to add
  When I run the route to add a link
  Then I should have this link in base
