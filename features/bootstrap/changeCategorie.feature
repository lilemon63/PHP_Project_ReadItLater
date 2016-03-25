# features/changeCategorie.feature
Feature: changeCategorie
	Here we test if we can change
	the categorie of a link.
	
Scenario: change categorie of a link
  Given a categorie and a link
  When I run the route to change categorie
  Then I should have the categorie changed for this link
