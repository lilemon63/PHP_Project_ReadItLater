# features/archiveLink.feature
Feature: archiveLink
	Here we look if we can 
	archive a link.
	
	
Scenario: Archive a link
  Given a link to archive
  When I run the route to archive a link
  Then I should have the link archived
