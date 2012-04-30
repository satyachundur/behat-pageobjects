<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Mink\Element,
    Behat\Behat\Context\Step;


class Common_Steps_Login extends BehatContext
{
    private $_baseUrl;
    
    private $_lastPage = null;

    public function __construct(array $parameters)
    {
        $this->_baseUrl = $parameters['base_url'];
        $this->_fixtures = $parameters['fixtures'];

        $this->_fixtures->get('vms_test')->setFixtureDir('Common/fixtures/login/vms_test');
        $this->_fixtures->get('users_test')->setFixtureDir('Common/fixtures/login/users_test');
    }

    /**
     * @Then /^the logged in page displays$/
     */
    public function loggedInPageDisplays()
    {        
       assertTrue($this->_lastPage->isUserLoggedIn(), "User not logged in");
    }

        /**
     * @Then /^the registration page displays$/
     */
    public function registrationPageDisplays()
    {
        assertTrue($this->_lastPage->isRegistrationPage(), "Registration page is not displaying");
    }
    
    /**
     * @Then /^I should see "([^"]*)" on page$/
     */
    public function iShouldSeeNameOnPage($name)
    {
        assertTrue($this->_lastPage->hasUserNameOnPage($name), "User's name is not displaying");
    }
    
    /**
    * @Given /^I am logged in as "([^"]*)" with password "([^"]*)"$/
    */
    public function iAmLoggedInAsWithPassword($email, $password)
    {
        $page = new Common_Pages_Home($this->getMainContext()->getSession());
        $this->_lastPage = $page->loginAs($email, $password);
    }/**/
}
