<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

interface ParameterDefinition
{
    public function getName() : string;
    public function isRequired() : bool;
}
