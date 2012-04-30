<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Mink\Element,
    Behat\Behat\Context\Step;


class Common_Steps_Home extends BehatContext
{
    private $_baseUrl;

    public function __construct(array $parameters)
    {
        $this->_baseUrl = $parameters['base_url'];

    }

    public function getUrl()
    {
        return $this->getMainContext()->getSession()->getCurrentUrl();
    }

     /**
     * @AfterScenario @logoff
     */
    public function logoff()
    {
        echo "End of scenario - logging off VMS \n";
        $this->getMainContext()->getDriver()->click(".//*[@id='login']/a");
        $this->getMainContext()->getSession()->wait('2000');
    }

    /**
     * @Given /^the Manage Overlays page displays$/
     */
    public function theManageOverlaysPageDisplays()
    {
        $this->getMainContext()->getDriver()->visit('/overlays');
        $this->getMainContext()->getSession()->wait('2000');
        $_currentUrl = $this->getUrl();
        assertTrue($_currentUrl == "http://test.videos.com/overlays", "Failed to navigate to Manage Overlays page");
    }

    /**
     * @Then /^the homepage is displayed$/
     */
    public function theHomePageIsDisplayed()
    {
        $this->getMainContext()->getDriver()->visit('/');
        $this->getMainContext()->getSession()->wait('2000');
        echo $this->getUrl();
        //check that the Manage Overlays link is visible
        assertTrue($this->getMainContext()->getSession()->getPage()->has("xpath", ".//*[@id='navigation-overlays']/a"), "Failed to display the Manage Overlays link");

    }

     /**
     * @Then /^the IM can navigate to Manage Overlays$/
     */
    public function theImCanNavigateToManageOverlays()
    { 
        $this->getMainContext()->getSession()->wait('2000');
        $this->getMainContext()->getDriver()->click(".//*[@id='navigation-overlays']/a");
        $this->getMainContext()->getSession()->wait('2000');

        //assert url is correct
         $_currentUrl = $this->getUrl();
         assertTrue($_currentUrl == "http://test.videos.com/overlays", "Failed to navigate to Manage Overlays page");
        
    }

     /**
     * @Then /^no videos are selected$/
     */
    public function noVideosAreSelected()
    {
        assertFalse($this->getMainContext()->getSession()->getPage()->has("xpath", ".//div[@class='main-span']"), "Videos are displaying");
    }

    /**
     * @Then /^Manage Overlays step is disabled$/
     */
     public function manageOverlaysStepIsDisabled()
     {

         assertTrue($this->getMainContext()->getSession()->getPage()->has("xpath", "//ul[@class='nav nav-pills']/li[@class='disabled'][1]"), "Step 2 Manage Overlays link is not disabled");
     }

     /**
     * @Given /^the Publish Videos step is disabled$/
     */
    public function thePublishVideosStepIsDisabled()
    {
        assertTrue($this->getMainContext()->getSession()->getPage()->has("xpath", "//ul[@class='nav nav-pills']/li[@class='disabled']/following-sibling::*[1]"), "Step 3 Publish Videos link is not disabled");
    }


}
?>
