<?php

class Common_Pages_UI_Login extends Common_Pages_UI_Base
{
    private $_username  = ".//*[@id='username']";
    private $_password  = ".//*[@id='password']";
    private $_login     = ".//input[@type='submit']";
    private $_loggedinUsername = ".//span[@class='userfd-name']";
    
    public function __get($name)
    {
        $varName = "_$name";
        if (!isset($this->$varName)) {
            throw new InvalidArgumentException("Element $name is not defined on this page.");
        }
        
        if (!in_array($name, $this->elements)) {
              try {
                  $this->elements[$name] = new Behat\Mink\Element\NodeElement($this->$varName, $this->session);
              } catch (Exception $e) {
                  return;
              }
        }
        
        return $this->elements[$name];
    }
    
    private function initFields()
    {
        $this->elements['username'] = new Behat\Mink\Element\NodeElement(self::USERNAME, $this->session);
        $this->elements['password'] = new Behat\Mink\Element\NodeElement(self::PASSWORD, $this->session);
        $this->elements['login'   ] = new Behat\Mink\Element\NodeElement(self::LOGIN, $this->session);
        $this->elements['loggedinUsername'] = new Behat\Mink\Element\NodeElement(self::LOGGEDIN_USERNAME, $this->session);
    }
}