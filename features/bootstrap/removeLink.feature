# features/removeLink.feature
Feature: removeLink
	Here we test if we can change
	remove a link properly.
	
Scenario: Remove a link
  Given a link to remove
  When I run the route to remove a link
  Then I should have the link removed
