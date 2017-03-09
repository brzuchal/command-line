<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

$definition = new \Brzuchal\CommandLine\CommandLineDefinition([
    new \Brzuchal\CommandLine\ArgumentDefinition('command'),
    new \Brzuchal\CommandLine\OptionDefinition('env', 'e'),
    new \Brzuchal\CommandLine\OptionDefinition('file', 'f'),
    new \Brzuchal\CommandLine\OptionDefinition('count', 'c'),
]);

$parser = new \Brzuchal\CommandLine\ArrayCommandLineParser($_SERVER['argv'], $_SERVER['PWD'], $definition);
$commandLine = $parser->parse();
print_r($commandLine->toArray());