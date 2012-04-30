#@story1456
#@voms
Feature: Enable Disable overlays feature
    In order to build an engaging player
    As an Implementation Manager
    I want the ability to enable and disable the associated overlays for the selected content

    @ignore
    Scenario: Overlays that have been associated prior are enabled by default
        Given I am an IM and have already associated overlays to selected content
        When I am viewing the list of associated overlays interface
        Then I expect the overlays to be enabled by default
        And for the overlays to be in order of when they were selected

    @ignore
    Scenario: An IM disables an associated overlay
        Given I am an IM and have associated overlays to selected content
        When I select the disable function
        Then I expect the overlay to be un-associated from the content
        And for it to be removed from the previewed player

    @interface
    Scenario: Overlay disabled
        Given video version 1 has an overlay enabled 
        When I switch the overlay switch to disable the overlay
        Then overlay is disabled
        #And that overlay no longer visible in the preview

    @interface
    Scenario: Overlay enabled
        Given video has an overlay disabled 
        When I switch the overlay switch to enable the overlay
        Then overlay is enabled
        #And that overlay no longer visible in the preview

    @service
    Scenario: Overlay disable service
        Given video 1 has an overlay enabled
        When I disable the overlay
        Then overlay is disabled
    
    @service
    Scenario: Overlay enable service
        Given video 1 has an overlay disabled
        When I enabled the overlay
        Then overlay is enabled



