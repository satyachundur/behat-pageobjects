#Story 1453
@javascript
Feature: Homepage
    In order to navigate to other areas of the overlay managing tool
    As an Implementation Manager
    I want a homepage for an overlay managing interface

    Background:
        Given I am on "http://test.videos.com/"
        And I am logged in as "test" with password "test"

    @logoff
    Scenario: Homepage displayed
        Then the homepage is displayed
        And the IM can navigate to Manage Overlays

    @logoff
    Scenario: First visit to Manage Overlays page displays with no videos selected
        Given the Manage Overlays page displays
        Then no videos are selected
        And Manage Overlays step is disabled
        And the Publish Videos step is disabled
    
