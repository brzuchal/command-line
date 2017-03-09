<?php declare(strict_types = 1);
require_once __DIR__ . '/../vendor/autoload.php';

$builder = (new \Brzuchal\CommandLine\CommandLineBuilder())
    ->withArgument('command')
    ->withOption('file', 'f')
    ->withOption('count', 'c', true);

$arguments = [$argv[0], 'serve', '-f', 'bootstrap.php', '-c5']; // equivalent of: php builder.php serve -f bootstrap.php -c5

$commandLine = $builder->build($arguments, $_SERVER['PWD']);

print_r($commandLine->toArray());