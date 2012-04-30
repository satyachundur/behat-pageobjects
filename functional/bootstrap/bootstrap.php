<?php
defined('GV_APP_ENV') || define('GV_APP_ENV', 'test');
            
//get common config settings
$bootstrapFile = realpath(dirname(__FILE__) .
        DIRECTORY_SEPARATOR . '..' .
        DIRECTORY_SEPARATOR . '..' .
        DIRECTORY_SEPARATOR . '..' .
        DIRECTORY_SEPARATOR . 'bootstrap.php');

if (empty($bootstrapFile)) {
    throw new Exception('The bootstrap file is not found.');
}

require $bootstrapFile;

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(FALSE);
$autoloader->registerNamespace("Overlays_");
$autoloader->registerNamespace("CQRS_");
$autoloader->registerNamespace("ClassStructure_");
        //stop the pretty class warning
$autoloader->suppressNotFoundWarnings(true);


        
// set include paths
$includePaths = array (
    realpath(GV_APP_VMS_PATH_APPLICATION . '/../tests/functional/features'),
    GV_APP_VMS_PATH_APPLICATION, get_include_path ()
);
set_include_path(join(PATH_SEPARATOR, $includePaths));

$dbConfigFile = realpath(dirname(__FILE__) .
        DIRECTORY_SEPARATOR . '..' .
        DIRECTORY_SEPARATOR . '..' .
        DIRECTORY_SEPARATOR . '..' .
        '/config/test/db.conf.php');
$config = new Zend_Config(require($dbConfigFile));
Zend_Registry::set('dbConfig', $config);
