#Story1454
# to:do @addTemplates
# to:do @addVideo
@javascript
 Feature: Add and remove overlays
        In order to create an interactive and engaging experience for the user
        As an Implementation Manager
        I want the ability to add and remove new layers and overlays to selected content
    

    Background:
        Given I am on "http://test.videos.com/"
        When I fill in "username" with "test"
        When I fill in "password" with "test"
        When I press "login"

  
    @service
    Scenario: Video service 1
        Given I have selected video version "1" 
        And I have selected an overlay template "2"
        When I add an overlay
        Then I expect the overlay to be attached to the video version
        And I expect the video version overlay counter to be incremented
    
    @service
    Scenario: Video service 2
        Given I have selected video "3" 
        And I have selected an overlay template "2"
        When I add an overlay
        Then I expect the overlay to be attached to the video
        And I expect the video overlay counter to be incremented

    @interface
    Scenario: Add an overlay
        Given I am on the library interface screen
        When I select a template from the library interface screen
        Then I will be taken to the manage overlays screen
        And I will see that overlay associated to the content item
        And the last added overlay will appear as the bottom most overlay layer
        And it will be enabled by default

    @interface
    Scenario: Overlay template configuration
        Given I am on the manage overlays screen
        And a content item has one or more overlays associated with it
        When I select one of the overlays
        Then I will see a configuration screen where I can adjust variables for that overlay
  
    @interface
    Scenario: More than 5 templates exist
        Given more than "5" templates exist in the template library
        When the overlays library interface is displayed
        Then I expect to see pagination


    @interface
    Scenario: Navigating from first page of templates to second page of templates
        Given the overlays library interface is displayed
        And the next pagination link is enabled
        When I click on the next pagination link
        Then I will be taken to the next page of templates on the library interface
    
  
    @service    
    Scenario: overlay template search request returns results
        Given templates named "ATest001", "BTest002", "Cat" and "Dog" exist 
        When a search string "Test00" is submitted
        Then I expect "ATest001" and "BTest002" to be returned and templates "Cat" and "Dog" to not be returned
        And results will be ordered "ATest001" followed by "BTest002"

    #TokenizedSearchNotToBeImplementedAtThisStageButMaybeLaterOn
    @service
    Scenario: tokenized search
        Given templates named "Test Template A", "Template B", "Test C" and "Testing D" exists
        When the search string "Test Template" is submitted
        Then I expect "Test Template A", "Template B", "Test C" and "Testing D" to be returned

    @interface
    Scenario: IM searches for overlay templates in the overlays library interface and matches returned
        Given more than 1 templates exist in the template library
        And the library interface screen is displayed
        And a search string has been entered in the template library search field
        When the search is made
        Then matching results are returned
        And results are ordered alphabetically       
  
    @service: 
    Scenario: search string with no matches
        Given no template exists with the name "Xyz001"
        When I search for string "Xyz001"
        Then no matches are returned
        

    @interface
    Scenario: IM searches for overlay templates in the overlays library interface and no matches returned
        Given more than 1 templates exist in the template library
        And the library interface screen is displayed
        And a search string that will not return matches has been entered in the template library search field
        When the search is made
        Then no results are returned
        And user is alerted appropriately with "sorry, there are no matching results"


    @service
    Scenario: Valid template file selected for upload
        Given a valid template file exists
        When I browse
        Then template file is marked for upload
 
    @service: 
    Scenario: Valid metafile selected for upload
        Given a valid etafile exists
        When I browse
        Then etafile is marked for upload
        
    @service: 
    Scenario: Non swf template file
        Given a non swf template file exists
        When I borswe to file
        Then template file is not marked for upload
       
    @service: 
    Scenario: Non XML Metafile        
        Given a non xml metafile exists
        When I browse to file
        Then metfile is not marked for upload

    @interface
    Scenario: IM uploads their own template and meta file
        Given I am viewing the library interface
        And the upload section is displayed
        And a valid swf file has been chosen for the template file
        And a valid xml file has been chosen as the meta file
        When I upload
        Then I will see the template and meta files indicated as being uploaded


    @interface
    Scenario: IM selects a Template File but no Meta File
        Given I am viewing the library interface
        And the upload section is displayed
        And I have selected a template File for upload
        And I have not selected a meta file for upload
        When I upload
        Then I will receive a warning
        And No file will be uploaded
        
    @interface
    Scenario: Template and metafile Uploaded and IM saves
        Given I am viewing the library interface
        And the upload section is displayed
        And a valid xml file and meta file has been uploaded
        When I save
        Then I will be taken to the library interface screen
        And my new template will be selectable from the template library
        
    @service
    Scenario: Newly added template and metafile added to content item
        Given valid template and metafiles have been uploaded
        And video Id 1 has been selected
        When I select the recently uploaded template
        Then I expect the overlay to be attached to video Id 1
        And I expect the video version overlay counter to be incremented by 1

    @service
    Scenario: Overlay removed from content item
        Given video Id 1 has an overlay associated to it
        And video Id 1 is selected
        When I remove overlay Item from video Id 1
        Then overlay is removed from Video Id 1
    
    @inteface
    Scenario: Remove overlay confirmation on manage overlays screen  
        Given a content item has more than one overlay associated
        And the manage overlays screen is displayed for that content item
        When I click remove overlay
        Then a remove overlay confirmation message is displayed
       
    @interface
    Scenario: remove overlay on manage overlays screen
        Given a remove overlay confirmation message is displayed
        When I accept the Confirmation
        Then that overlay is no longer visible in the manage overlays screen
       
    @interface
    Scenario: Decline remove overlay confirmation on manage overlays screen
        Given a remove overlay confirmation message is displayed
        When I decline the confirmation
        Then that overlay remains visible in the manage overlays screen

  @service
    Scenario: Remove template from template library no associated campaigns
        Given template 1 exists in the Template Library 
        And temaplte 1 is not used in any current campaigns
        When I remove template 1
        Then template 1 is removed from library

    @service
    Scenario: Remove template from template library with already associated campaign
        Given template 2 exists in the template library
        And template 2 is used in campaign 1
        When I remove template 2
        Then template 2 is removed from library
        And campign 1 remains unaffected by the template deletion
        

    @interface
    Scenario: Remove template from template library confirmation message
        Given a template exists
        And the library interface screen is displayed
        When I click on the remove template button
        Then I expect a remove template confirmation message to be displayed 

    @interface
    Scenario: Accept remove template from template library
        Given a template exists
        And the library interface screen is displayed
        And a remove template confirmation message is displayed
        When I accept the confirmation
        Then I am returned to the library interface screen
        And the template is removed from the template library
        And any live campaigns that use overlays generated from the removed template will remain unaffacted 
         
    @interface
        Scenario: Cancel remove template from template library
        Given a template exists
        And the library interface screen is displayed
        And a remove template confirmation message is displayed
        When I decline the confirmation
        Then I am returned to the library interface screen
        And no libraries have been removed
