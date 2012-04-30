#!/usr/bin/php
<?php
define('BASE_PATH', realpath(dirname(__FILE__) . '/../../'));

// Include path
set_include_path(
    BASE_PATH . '/lib' .
    PATH_SEPARATOR . get_include_path()
);

defined('APP_ENV') ||
	define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : 'test'));

require_once "Zend/Loader/Autoloader.php";
$autoloader = Zend_Loader_Autoloader::getInstance();

$autoloader->registerNamespace('Goviral_');

// videos db setup

$setupVideos = new Goviral_Test_Setup(APP_ENV, BASE_PATH, NULL);
$setupVideos->setMigrationsConfigPath(BASE_PATH . '/config/migrations/default.conf.php');
$setupVideos->setUp();

$config = new Zend_Config(require(BASE_PATH . '/config/test/db.conf.php'));

foreach ($config as $database) {

    $setup = new Goviral_Test_Setup(APP_ENV, BASE_PATH, NULL);
    $setup->setMigrationsConfigPath($database->migrationsConfigFilePath);
    $setup->setMigrationsDir($database->migrationsDir);
    $setup->setSchemaFilePath($database->migrationsDir . 'schema.sql');

    $credentials = array(
        'user' => $database->username,
        'password' => $database->password,
        'name' => $database->dbname
    );

    $setup->setDatabaseCredentials($credentials);
    $setup->setUp();
}

exit(0);