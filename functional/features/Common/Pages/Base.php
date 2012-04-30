<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Mink\Element,
    Behat\Behat\Context\Step,
    Behat\Mink\Session;

class Common_Pages_Base 
{
    /**
     * @var Behat\Mink\Session
     */
    protected $session = null;
    
    public function __construct(Behat\Mink\Session $session)
    {
        $this->session = $session;
    }
    
    protected function has($selector, $locator)
    {
        if (null === $this->session) {
            return false;
        }
        
        return $this->session->getPage()->has($selector, $locator);
    }
}