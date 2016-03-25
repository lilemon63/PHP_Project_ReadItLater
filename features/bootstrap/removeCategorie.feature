# features/removeCategorie.feature
Feature: removeCategorie
	Here we test if we can change
	remove a categorie properly.
	
Scenario: Remove a categorie
  Given a categorie to remove
  When I run the route to remove a categorie
  Then I should have the categorie removed
