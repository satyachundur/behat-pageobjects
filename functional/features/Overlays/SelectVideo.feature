#Story1627
Feature: Select Video Feature
    In order to apply an overlay to a video
    As an Implementation Manager
    I want to be able to select a video

Background:
    Given an IM has logged in

    @ignore  
    Scenario: Select Video
        When I select a video
        Then the video will be marked as selected
        Then the step 2 Overlays section is activated

    @interface 
    Scenario: Select Overlays Screen
        When I select a video
        Then I will be taken to the Manage Overlays screen
        And I will see a preview for the currently selected video
