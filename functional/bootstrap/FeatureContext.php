<?php

use Behat\Behat\Context\ClosuredContextInterface, Behat\Behat\Context\BehatContext, Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode, Behat\Gherkin\Node\TableNode, Behat\Behat\Context\Step;

require_once 'PHPUnit/Autoload.php';
        
require_once __DIR__ . '/../../../lib/behat/mink.phar';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends Behat\Mink\Behat\Context\MinkContext
{
    protected static $fixtures;
    
    public function __construct(array $parameters)
    {

        $this->_initContainer();
        $parameters['fixtures'] = self::$fixtures = $this->initFixtures();
        $this->useContext('Overlays_AddRemove', new Overlays_Steps_AddRemove($parameters));
        $this->useContext('Common_Home', new Common_Steps_Home($parameters));
        $this->useContext('Common_LogIn', new Common_Steps_Login($parameters));
    }
    
    /**
     * @BeforeFeature
     */
    public static function tearUpFixtures()
    {
        self::$fixtures->insertData();
    }
    
    /**
     * @AfterFeature
     */
    public static function tearDownFixtures()
    {
        self::$fixtures->tearDown();
    }
    
    /**
     * @AfterScenario @killDriver
    */
    public function cleanup()
    {
        $this->getDriver()->stop();
    }


    public function getDriver() 
    {
        return $this->getSession()->getDriver();
    } 
    
    private function _initContainer()
    {
        require_once(GV_APP_VMS_PATH_LIB. '/Symfony/sfServiceContainerAutoloader.php');

        $sfAutoloader = new sfServiceContainerAutoloader();

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(TRUE);
        $autoloader->pushAutoloader(array($sfAutoloader, 'autoload'));

        $container = new sfServiceContainerBuilder();
        
        $loader = new sfServiceContainerLoaderFileXml($container);
        $filename = GV_APP_VMS_PATH_CONFIG . '/' . GV_APP_ENV . '/services.xml';
        if (!is_readable($filename)) {
            $filename = GV_APP_VMS_PATH_CONFIG . '/services.xml';
        }
        $loader->load($filename);
        
        //save it for services as well
        $configFile = GV_APP_VMS_PATH_CONFIG .
                      DIRECTORY_SEPARATOR . GV_APP_ENV .
                      DIRECTORY_SEPARATOR . 'db.conf.php';
        $config = new Zend_Config(require($configFile));

        foreach ($config as $name => $database) {
            $container->setParameter("db_{$name}", $database->toArray());
        }    
        
        Zend_Registry::set('diContainer', $container);
    }
    
   
}