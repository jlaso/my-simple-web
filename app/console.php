#!/usr/bin/env php
<?php

define("ROOT_DIR", dirname(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

use app\command\DemoCommand;
use JLaso\TranslationsApiConnector\Command\TranslationsHelperCommand;
use JLaso\TranslationsApiConnector\Command\TranslationsExtractCommand;

use Symfony\Component\Console\Application;
use Symfony\Component\Config\FileLocator;

$configDirectories = array(ROOT_DIR.'/app/config');

$locator = new FileLocator($configDirectories);
$parameters = $locator->locate('parameters.yml', null, false);

var_dump($parameters);

$application = new Application();

$application->add(new DemoCommand);
$application->add(new TranslationsHelperCommand);
$application->add(new TranslationsExtractCommand);

$application->run();