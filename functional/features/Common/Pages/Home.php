<?php 

class Common_Pages_Home extends Common_Pages_Base
{    
    public function loginAs($username, $password)
    {
        $uiElements = new Common_Pages_UI_Login($this->session);
        
        $this->session->visit('/');
        
        $uiElements->username->setValue($username);
        $uiElements->password->setValue($password);
        $uiElements->login->press();
        
        //wait for page to load
        sleep(1);
        
        return new self($this->session);
    }
    
    public function loginAsExpectingLoginPage($username, $password)
    {
        $this->initFields();
        
        $this->session->visit('/');
        $this->username->setValue($username);
        $this->password->setValue($password);
        $this->login->press();
        
        return new Common_Pages_Login($this->session);
    }
    
    public function isUserLoggedIn()
    {
        $uiElements = new Common_Pages_UI_Login($this->session);
        
        return $uiElements->loggedinUsername ? true : false;
    }
    
    public function isRegistrationPage()
    {
        return $this->has("xpath", "//div[@class='padding']/p");
    }
    
    public function hasUserNameOnPage($name)
    {
        return strpos($this->session->getPage()->getContent(), $name) !== false;
    }
    
}
