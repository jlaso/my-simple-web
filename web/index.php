<?php

session_cache_limiter(false);
session_start();

date_default_timezone_set('Europe/Madrid');

define ('ROOT_DIR', dirname(__DIR__));

require_once ROOT_DIR . '/vendor/autoload.php';
Twig_Autoloader::register();

// DB access
require_once ROOT_DIR . '/app/config/dbconfig.php';
ORM::configure('mysql:host='.DBHOST.';dbname='.DBNAME);
ORM::configure('username', DBUSER);
ORM::configure('password', DBPASS);

// Prepare app
$app = new \Router\SlimExt(array(
    'templates.path'    => ROOT_DIR . '/app/templates',
    'log.level'         => 4,
    'log.enabled'       => true,
//    'log.writer'        => new \Slim\Extras\Log\DateTimeFileWriter(array(
//                                'path'          => ROOT_DIR . '/app/logs',
//                                'name_format'   => 'y-m-d'
//                           )),
    'view'              => new \lib\Twig(),
    )
);

$languages = app\config\Config::getInstance()->getLanguageCodes();
\Slim\Route::setDefaultConditions(array(
    'lang' => implode('|', $languages)
));

// Define routes for controller
require_once ROOT_DIR . '/app/controller/autoload.php';

$view = $app->view();
$view->parserOptions = array(
    'charset'           => 'utf-8',
    'cache'             => ROOT_DIR . '/app/cache',
    'auto_reload'       => true,
    'strict_variables'  => false,
    'autoescape'        => true
);
$view->parserExtensions = array(
    new \lib\TwigViewSlim(),
);

// Run app
$app->run();
