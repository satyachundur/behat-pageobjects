#@story1455
Feature: Reordering Overlays
    In order configure which overlay has priority over the other
    As an Implementation Manager
    I want the ability to reorder the visibility of the overlays

    @ignore
    Scenario: Overlays ordering screen
            Given I am an IM with a piece of content 
            When I vist the screen for ordering overlays
            And I select a content item
            Then I see an interface which allows me to order overlays for that content item

    @interface
    Scenario: Manage overlays screen shows order
        Given I am on the manage overlays screen
        Then I see the order of all assocaited overlays
     
    @ignore
    Scenario: Move overlay from topmost to bottommost
            Given I am an IM with a piece of content 
            And content has multiple overlays associated
            When I move the topmost overlay to the bottom
            Then I expect the moved overlay to now sit at the bottom of the stack
            And the overlay that was bottommost now sits moves up one layer

    @interface
    Scenario: Move overlay down a level
            Given a video has more than one overlay
            And I am on the overlays management screen for that video
            When I drag an overlay down a level
            Then I expect it to move down a level
            And it's order to be decreased by one


    @interface
    Scenario: Move overaly up a level
            Given a video has more than one overlay
            And I am on the overlays management screen for that video
            When I drag an overlay up a level
            Then I expect it to move up a level
            And it's order to be increased by one

    @service
    Scenario: Move overlay from bottommost to topmost
            Given a video has 2 overlays associated  
            And video is selected
            When I move the lower overlay up a level
            Then I expect the moved overlay to now sit at level 1 of the stack
            And the overlay that was at level 1 now moves down a level
    
    @service
    Scenario: Move overlay from topmost to bottommost
            Given a video has 2 overlays associated  
            And video is selected
            When I move the upper overlay down a level
            Then I expect the moved overlay to now sit at level 2 of the stack
            And the overlay that was at level 2 now moves up a level
        






        
       
     

        

