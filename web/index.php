<?php

session_cache_limiter(false);
session_start();

date_default_timezone_set('Europe/Madrid');

require_once '../vendor/autoload.php';
Twig_Autoloader::register();

// lib
//require_once '../lib/autoload.php';

// DB access
require_once '../app/config/dbconfig.php';
ORM::configure('mysql:host='.DBHOST.';dbname='.DBNAME);
ORM::configure('username', DBUSER);
ORM::configure('password', DBPASS);

// Prepare view
\lib\TwigViewSlim::$twigOptions = array(
    'charset'           => 'utf-8',
    'cache'             => realpath('../app/cache'),
    'auto_reload'       => true,
    'strict_variables'  => false,
    'autoescape'        => true
);

// Prepare app
$app = new \Router\SlimExt(array(
    'templates.path'    => '../app/templates',
    'log.level'         => 4,
    'log.enabled'       => true,
    'log.writer'        => new \Slim\Extras\Log\DateTimeFileWriter(array(
                                'path'          => '../app/logs',
                                'name_format'   => 'y-m-d'
                           )),
    'view'              => new \lib\TwigViewSlim(),
    )
);

$languages = app\config\Config::getInstance()->getLanguageCodes();
\Slim\Route::setDefaultConditions(array(
    'lang' => implode('|',$languages)
));

// access to models
//require_once '../app/models/autoload.php';

// Define routes for controller
require_once '../app/controller/autoload.php';

// Run app
$app->run();
