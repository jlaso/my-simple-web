#!/usr/bin/env php
<?php

define("ROOT_DIR", dirname(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

use app\command\DemoCommand;
use JLaso\TranslationsApiConnector\Command\TranslationsHelperCommand;
use JLaso\TranslationsApiConnector\Command\TranslationsExtractCommand;
use Symfony\Component\Yaml\Yaml;

use Symfony\Component\Console\Application;
use Symfony\Component\Config\FileLocator;

$locator = new FileLocator(array(ROOT_DIR.'/app/config'));
$files = $locator->locate('parameters.yml', null, false);
$config = array();

foreach($files as $file){
    $current = Yaml::parse(file_get_contents($file));
    $config = array_merge($config, $current);
}

$application = new Application();
$application->config = $config;
$application->addCommands(
    array(
        new DemoCommand,
        new TranslationsHelperCommand,
        new TranslationsExtractCommand,

    )
);
$application->run();