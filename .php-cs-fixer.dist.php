<?php

$finder = PhpCsFixer\Finder::create()
    ->in(dirname(__DIR__).'\Blog\src')
;

$config = new PhpCsFixer\Config();
return $config->setRules(['@Symfony' => true,])->setUsingCache(false)->setFinder($finder);