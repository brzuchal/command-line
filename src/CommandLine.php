<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

use InvalidArgumentException;

class CommandLine
{
    /**
     * @var string Holds command filename
     */
    protected $command;
    /**
     * @var Parameter[] Holds parameters and options
     */
    protected $parameters = [];
    /**
     * @var string Holds current working directory
     */
    protected $cwd;

    public function __construct(string $command, array $parameters = [], string $cwd = null)
    {
        $this->command = $command;
        foreach ($parameters as $parameter) {
            if ($parameter instanceof Parameter) {
                if ($parameter instanceof Argument && $this->hasArgument($parameter->getName())) {
                    throw new InvalidArgumentException("Given argument: {$parameter->getName()} already exists");
                }
                if ($parameter instanceof Option && $this->hasOption($parameter->getName())) {
                    throw new InvalidArgumentException("Given option: {$parameter->getName()} already exists");
                }
                $this->parameters[] = $parameter;
            }
        }
        $this->cwd = $cwd;
    }

    public function getCommand() : string
    {
        return $this->command;
    }

    public function hasArgument(string $name) : bool
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter instanceof Argument && $parameter->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    public function getArgument(string $name) : ?Argument
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter instanceof Argument && $parameter->getName() === $name) {
                return $parameter;
            }
        }

        return null;
    }

    public function hasOption(string $name) : bool
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter instanceof Option && $parameter->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    public function getOption(string $name) : ?Option
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter instanceof Option && $parameter->getName() === $name) {
                return $parameter;
            }
        }

        return null;
    }

    public function getCwd() : string
    {
        return $this->cwd;
    }

    public function toArray() : array
    {
        $result = [];
        foreach ($this->parameters as $parameter) {
            $result[$parameter->getName()] = $parameter->getValue();
        }

        return $result;
    }
}
