<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */

$loader = require __DIR__.'/../vendor/autoload.php';/*
$loader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/../vendor/beberlei/DoctrineExtensions');*/
$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions','/../vendor/beberlei/DoctrineExtensions');

$loader = require __DIR__.'/../vendor/autoload.php';
$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/../vendor/beberlei/DoctrineExtensions');

$classLoader->register();
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
