<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

class ArrayCommandLineParser implements CommandLineParser
{
    /**
     * @var array Holds parameters to parse
     */
    protected $parameters;
    /**
     * @var int Holds internal pointer
     */
    protected $pointer = 1;
    /**
     * @var string Holds current working directory
     */
    protected $cwd;
    /**
     * @var ?CommandLineDefinition Holds argument and option definitions
     */
    protected $definition;

    public function __construct(array $parameters, string $cwd = null, ?CommandLineDefinition $definition = null)
    {
        $this->parameters = $parameters;
        $this->cwd = $cwd;
        $this->definition = $definition;
    }

    public function parse() : CommandLine
    {
        $parameters = [];
        $arguments = 0;
        $command = $this->parameters[0];
        for ($this->pointer = 1; \array_key_exists($this->pointer, $this->parameters); $this->pointer++) {
            $parameter = $this->parameters[$this->pointer];
            $nextParameter = \array_key_exists($this->pointer + 1, $this->parameters) ? $this->parameters[$this->pointer + 1] : null;
            if ($this->isOption($parameter)) {
                $parameters[] = $this->parseOption($parameter, $nextParameter);
            } else {
                $parameters[] =$this->parseArgument($parameter, $arguments);
                $arguments++;
            }
        }

        return new CommandLine($command, $parameters, $this->cwd);
    }

    protected function parseOption(string $parameter, string $nextParameter = null) : Option
    {
        $name = $this->getOptionName($parameter);
        $value = null;
        $isValueRequired = false;

        if ($this->definition instanceof CommandLineDefinition && $this->definition->hasOptionDefinition($name)) {
            $optionDefinition = $this->definition->getOptionDefinition($name);
            $name = $optionDefinition->getName();
            $isValueRequired = $optionDefinition->isValueRequired();
        }

        if ($this->hasOptionValue($parameter)) {
            $value = $this->getOptionValue($parameter);
        } else {
            if (null === $nextParameter) {
                if (true === $isValueRequired) {
                    throw new \UnexpectedValueException("Missing option {$name} value");
                }
                $value = true;
            } else {
                if ($this->isOption($nextParameter)) {
                    if (true === $isValueRequired) {
                        throw new \UnexpectedValueException("Missing option {$name} value");
                    }
                } else {
                    $value = $nextParameter;
                    $this->pointer++;
                }
            }
        }

        return new Option($name, $value);
    }

    protected function isOption(string $parameter) : bool
    {
        return 0 === \strpos($parameter, '-');
    }

    protected function isShortOption(string $parameter) : bool
    {
        return $this->isOption($parameter) && ('-' !== \substr($parameter, 1, 1));
    }

    protected function getOptionName(string $parameter) : string
    {
        if ($this->isShortOption($parameter)) {
            return \substr($parameter, 1, 1);
        }

        $valuePosition = \strpos($parameter, '=');
        if ($valuePosition) {
            return \substr($parameter, 2, $valuePosition - 2);
        }

        return \substr($parameter, 2);
    }

    protected function hasOptionValue(string $parameter) : bool
    {
        $length = \strlen($parameter);
        if ($this->isShortOption($parameter) && $length > 2) {
            return true;
        }
        if ($length === 2) {
            return false;
        }

        return strpos(ltrim($parameter, '-'), '=') !== false;
    }

    protected function getOptionValue(string $parameter) : string
    {
        $valuePosition = strpos($parameter, '=');

        if ($this->isShortOption($parameter) && false === $valuePosition) {
            return \substr($parameter, 2);
        }

        return \substr($parameter, $valuePosition + 1);
    }

    protected function parseArgument(string $parameter, int $arguments) : Argument
    {
        if ($this->definition instanceof CommandLineDefinition) {
            try {
                $argumentDefinition = $this->definition->getArgumentDefinitionAtPosition($arguments);
                return new Argument($argumentDefinition->getName(), $parameter);
            } catch (\OutOfBoundsException $e) {
                // There is no such argument definition
            }
        }

        return new Argument("arg{$arguments}", $parameter);
    }
}
