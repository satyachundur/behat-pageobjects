<?php
//namespace Overlays\steps;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;

class Overlays_Steps_AddRemove extends BehatContext
{
    private $_sqlFileSize;
    
    private $_baseUrl;
    
    private $_data = array();

    public function __construct(array $parameters)
    {
        $this->_baseUrl = $parameters['base_url'];
    }
    

    
    /**
     * @Given /^I have selected video version "([^"]*)"$/
     */
    public function iHaveSelectedVideoVersion($videoVersionId)
    {
        $this->_data['videoType'] = Overlays_Overlay_Overlay::OVERLAY_ENTITY_TYPE_VIDEO_VERSION;
        $this->_data['contentId'] = $videoVersionId;
    }

    /**
     * @Given /^I have selected an overlay template "([^"]*)"$/
     */
    public function iHaveSelectedAnOverlayTemplate($templateId)
    {
        $container = Zend_Registry::get('diContainer');
        $adapter = $container->getService("db.vms");
        $sql = $this->getSqlForVideoOverlayTemplates();
        $adapter->exec($sql);        
        $this->_data['templateId'] = $templateId;
    }
    
    /**
     * @When /^I add an overlay$/
     */
    public function iAddAnOverlay()
    {
        $container = Zend_Registry::get('diContainer');
        
        $queryService = $container->getService("overlaysDataQueryService");
        if ($this->_data['videoType'] == Overlays_Overlay_Overlay::OVERLAY_ENTITY_TYPE_VIDEO_VERSION) {
            //remember these for comparison after adding            
            $this->_data['overlays']['before'] = $queryService->getOverlaysForVideoVersion($this->_data['contentId']);
            $overlayService = $container->getService('overlaysVideoVersionService');   
        } else {
            //remember these for comparison after adding            
            $this->_data['overlays']['before'] = $queryService->getOverlaysForVideo($this->_data['contentId']);
            $overlayService = $container->getService('overlaysVideoService');      
        }     
         
        $overlayService->addOverlay($this->_data['contentId'], $this->_data['templateId']);
    }
    
    /**
     * @Then /^I expect the overlay to be attached to the video version$/
     */
    public function iExpectTheOverlayToBeAttachedToTheVideoVersion()
    {
        $this->_checkOverlayAdded(Overlays_Overlay_Overlay::OVERLAY_ENTITY_TYPE_VIDEO_VERSION);
    }
    
    /**
     * @Given /^I expect the video version overlay counter to be incremented$/
     */
    public function iExpectTheVideoVersionOverlayCounterToBeIncremented()
    {
        $this->_checkOverlayCounterHasIncreased();
    }
    
    /**
     * @Given /^I have selected video "([^"]*)"$/
     */
    public function iHaveSelectedVideo($videoId)
    {
        $this->_data['videoType'] = Overlays_Overlay_Overlay::OVERLAY_ENTITY_TYPE_VIDEO;
        $this->_data['contentId'] = $videoId;
    }
    
    /**
     * @Then /^I expect the overlay to be attached to the video$/
     */
    public function iExpectTheOverlayToBeAttachedToTheVideo()
    {
        $this->_checkOverlayAdded(Overlays_Overlay_Overlay::OVERLAY_ENTITY_TYPE_VIDEO);
    }
    
    /**
     * @Given /^I expect the video overlay counter to be incremented$/
     */
    public function iExpectTheVideoOverlayCounterToBeIncremented()
    {
        $this->_checkOverlayCounterHasIncreased();
    }
    
    private function _checkOverlayAdded($contentType)
    {        
        $container = Zend_Registry::get('diContainer');
        $queryService = $container->getService("overlaysDataQueryService");
        if (Overlays_Overlay_Overlay::OVERLAY_ENTITY_TYPE_VIDEO_VERSION == $contentType) {
            $this->_data['overlays']['after'] = $queryService->getOverlaysForVideoVersion($this->_data['contentId']);
        } else {
            $this->_data['overlays']['after'] = $queryService->getOverlaysForVideo($this->_data['contentId']);            
        }
        
        $results = array_diff_key($this->_data['overlays']['after'], $this->_data['overlays']['before']);
        
        assertEquals(1, count($results));
        $overlay = current($results);
        assertEquals($contentType, $overlay['entity_type_id']);
        assertEquals($this->_data['contentId'], $overlay['entity_id']);               
    }

    private function _checkOverlayCounterHasIncreased()
    {
        $increment = count($this->_data['overlays']['after']) - count($this->_data['overlays']['before']);
        assertEquals(1, $increment, "Overlay has not been added");
    }
    
    /**
     * @Given /^I am on the library interface screen$/
     */
    public function iAmOnTheLibraryInterfaceScreen()
    {
        $this->databaseSetVideoWithNoOverlaysAdded();
        //after removealloverlays add assertion to check database is cleared
        $browser = $this->getMainContext()->getDriver()->getBrowser();
        $this->getMaincontext()->getDriver()->visit("http://test.videos.com/overlays/manage-overlays/?content_id=2@content_type=2");
        //find out how to get base url from yml
        //print_r(get_class_methods($this->getMainContext()->getDriver()->getBrowser()));
        //print_r(get_class_methods($this->getMainContext()->getDriver()));   
        //lose sleeps
        sleep(3);
        $this->getMaincontext()->getDriver()->click('html/body/div[2]/div[2]/div[1]/div[1]/a'); 
        sleep(2);
        $this->getMaincontext()->getDriver()->click(".//*[@id='overlays-template-library-header']/div[2]/div/ul/li[1]/a");     
        
    }

    /**
     * @When /^I select a template from the library interface screen$/
     */
    public function iSelectATemplateFromTheLibraryInterfaceScreen()
    {       
        $this->getMaincontext()->getDriver()->click(".//*[@id='2']/div/div[3]/a[1]");
        //assert count fr    
    }

    /**
     * @Then /^I will be taken to the manage overlays screen$/
     */
    public function iWillBeTakenToTheManageOverlaysScreen()
    {
       assertFalse($this->getMaincontext()->getDriver()->GetBrowser()->isElementPresent(".//*[@id='overlays-template-library']"));
     //maybe at a git url to assert you at the correct url   
    }

    /**
     * @Given /^I will see that overlay associated to the content item$/
     */
    
    public function iWillSeeThatOverlayAssociatedToTheContentItem()
    {
        //throw new PendingException();
        sleep(1);       
        $this->databaseGetOverlayId();        
        $newOverlayId = $this->_data['newOverlayId'];
        $expectedXpath = ".//*[@id='" . $newOverlayId . "']";
        echo $expectedXpath;
        sleep(1);
        assertTrue($this->getMaincontext()->getDriver()->GetBrowser()->isElementPresent("$expectedXpath"));
        sleep(10);
//  print_r(AssertTrue($this->getMaincontext()->getDriver()->GetBrowser()->isElementPresent("$expectedXpath")));
//AssertTrue($this->getMaincontext()->getDriver()->GetBrowser()->isElementPresent(".//*[@id='$result']"));
    }

    /**
     * @Given /^the last added overlay will appear as the bottom most overlay layer$/
     */
    public function theLastAddedOverlayWillAppearAsTheBottomMostOverlayLayer()
    {
        //throw new PendingException();
    }

    /**
     * @Given /^it will be enabled by default$/
     */
    public function itWillBeEnabledByDefault()
    {
        $newOverlayId =  $this->_data['newOverlayId'];
        echo $newOverlayId;
        
        AssertTrue($this->getMaincontext()->getDriver()->getBrowser()->isElementPresent("//input[@checked='checked']/parent::*/parent::*/parent::li[@overlay-id='$newOverlayId']"));
        //throw new PendingException();
    }
    
        /**
     * @Given /^no template exists with the name "([^"]*)"$/
     */
    public function noTemplateExistsWithTheName($argument1)
    {   
        $container = Zend_Registry::get('diContainer');
        $adapter = $container->getService("db.vms");
        $sql = $this->getSqlToDeleteTemplateNamedXyz001();
        $adapter->exec($sql);
        
    }

    /**
     * @When /^I search for string "([^"]*)"$/
     */
    public function iSearchForString($templateSearchString)
    {
        $container = Zend_Registry::get('diContainer');
        $queryService = $container->getService("templatesDataQueryService");
        $this->_data['searchForTemplateQueryService'] = $queryService->getTemplates(NULL, NULL, $templateSearchString);
    }

    /**
     * @Then /^no matches are returned$/
     */
    public function noMatchesAreReturned()
    {
        assertEmpty($this->_data['searchForTemplateQueryService'], "queryService returned something when should have been Null");
    }


    private function getSqlToDeleteTemplateNamedXyz001()
    {
        $myDeleteTemplateTitleXyz001File = __DIR__ . "/../fixtures/testfiles/sql/DeleteTemplateTitleXyz001.sql";
        $sql = file_get_contents($myDeleteTemplateTitleXyz001File);
        return $sql;        
    }
    
    
    private function databaseSetVideoWithNoOverlaysAdded()
    {  
        $sqlSourceFile = __DIR__ . "/../fixtures/testfiles/sql/VideoWithNoOverlaysAdded.sql";
        $sql = file_get_contents($sqlSourceFile);
        $container = Zend_Registry::get('diContainer');
        $adapter = $container->getService("db.vms");
        $adapter->exec($sql);
        //put this in a try catch;
        
    }
    
    private function databaseSetVideoWithOneOverlayAdded()
    {
        $sqlSourceFile = __DIR__ . "/../fixtures/testfiles/sql/VideoWithOneOverlayAdded.sql";
        $sql = file_get_contents($sqlSourceFile);
        $container = Zend_Registry::get('diContainer');
        $adapter = $container->getService("db.vms");
        $adapter->exec($sql);
        //put this in a try catch;        
    }

    
    private function databaseGetOverlayId()
    {
        $sqlSourceFile = __DIR__ . "/../fixtures/testfiles/sql/GetNewOverlayId.sql";
        $sql = file_get_contents($sqlSourceFile);
        $container = Zend_Registry::get('diContainer');
        $adapter = $container->getService("db.vms");
        $newOverlayId = $adapter->fetchOne($sql);
        $this->_data['newOverlayId'] = $newOverlayId;
    }
}