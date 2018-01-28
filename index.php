<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 27.1.18
 * Time: 21.00
 */

require_once __DIR__ . '/vendor/autoload.php';

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder
    ->addDefinitions(__DIR__ . '/config.php')
    ->addDefinitions(__DIR__ . '/injections.php')
    ->useAutowiring(true);
$container = $containerBuilder->build();

$application = $container->get(\Radioactive\Application::class);
$application->start();