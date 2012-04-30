<?php
class Common_Pages_UI_Base 
{    
    protected $elements = array();

    /**
     * @var Behat\Mink\Session
     */
    protected $session = null;
    
    public function __construct(Behat\Mink\Session $session)
    {
        $this->session = $session;
    }
}