<?php declare(strict_types = 1);
require_once __DIR__ . '/../vendor/autoload.php';

$arguments = ['php', 'test.php', '--env', 'prod', '--debug', '--msg', 'ala'];

$commandLine = (new \Brzuchal\CommandLine\ArrayCommandLineParser($arguments))->parse();
print_r($commandLine->toArray());