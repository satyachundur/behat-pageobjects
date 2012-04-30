<?php

use Behat\Behat\Context\Step;
class Common_Pages_Login extends Common_Pages_Base
{
    public function loginAs($username, $password)
    {
        $this->context->visit('/');
        
        $this->session->visit('/');
        $this->username->setValue($username);
        $this->password->setValue($password);
        $this->login->press();
        
        return new self($this->session);
    }
    
    public function isUserLoggedIn()
    {
        return $this->has("xpath", ".//*[@id='login']");
    }
    
    public function hasUserNameOnPage($name)
    {
        return $this->context->assertPageContainsText($name);
    }
    
    protected function initFields()
    {
        $this->username = new Behat\Mink\Element\NodeElement(".//form[@id='form-user-login'] *[@id='username']", $this->session);
        $this->password = new Behat\Mink\Element\NodeElement(".//form[@id='form-user-login'] *[@id='password']", $this->session);
        $this->login = new Behat\Mink\Element\NodeElement(".//form[@id='form-user-login'] *[@id='login']", $this->session);
    }
    
}