# features/createCategorie.feature
Feature: createCategorie
	One requierement of this project was to
	have categories where links could be groupped,
	and this is what we are testing now.
	
Scenario: create a categorie
  Given a categorie name
  When I run the route to create a categorie 
  Then I should have this categorie created
