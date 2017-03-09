<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

interface CommandLineParser
{
    public function parse() : CommandLine;
}