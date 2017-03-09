<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

class CommandLineDefinition
{
    /**
     * @var ParameterDefinition[] Holds argument and option definitions
     */
    protected $definitions = [];

    /**
     * Definition constructor.
     * @param ParameterDefinition[] $definitions Argument and option definitions
     */
    public function __construct(array $definitions = [])
    {
        foreach ($definitions as $definition) {
            if ($definition instanceof ParameterDefinition) {
                $this->definitions[] = $definition;
            }
        }
    }

    public function hasArgumentDefinition(string $name) : bool
    {
        foreach ($this->definitions as $definition) {
            if ($definition instanceof ArgumentDefinition && $definition->getName() === $name) {
                return true;
            }
        }
        
        return false;
    }

    public function getArgumentDefinition(string $name) : ArgumentDefinition
    {
        foreach ($this->definitions as $definition) {
            if ($definition instanceof ArgumentDefinition && $definition->getName() === $name) {
                return $definition;
            }
        }

        throw new \OutOfBoundsException("Missing argument definition name: {$name}");
    }

    public function getArgumentDefinitionAtPosition(int $position) : ArgumentDefinition
    {
        $index = 0;
        foreach ($this->definitions as $definition) {
            if ($definition instanceof ArgumentDefinition && $index++ === $position) {
                return $definition;
            }
        }

        throw new \OutOfBoundsException("Missing argument definition at position: {$position}");
    }

    public function hasOptionDefinition(string $name) : bool
    {
        foreach ($this->definitions as $definition) {
            if ($definition instanceof OptionDefinition) {
                if ($definition->getName() === $name || $definition->getShortName() === $name) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getOptionDefinition(string $name) : OptionDefinition
    {
        foreach ($this->definitions as $definition) {
            if ($definition instanceof OptionDefinition) {
                if ($definition->getName() === $name || $definition->getShortName() === $name) {
                    return $definition;
                }
            }
        }

        throw new \OutOfBoundsException("Missing option definition name: {$name}");
    }
}
