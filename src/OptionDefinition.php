<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

class OptionDefinition implements ParameterDefinition
{
    /**
     * @var string Option name
     */
    protected $name;
    /**
     * @var string Option short name
     */
    protected $shortName;
    /**
     * @var bool Require flag
     */
    protected $required;
    /**
     * @var bool value require flag
     */
    protected $valueRequired;

    public function __construct(string $name, string $shortName, bool $required = false, bool $valueRequired = false)
    {
        $this->name = $name;
        $this->shortName = $shortName;
        $this->required = $required;
        $this->valueRequired = $valueRequired;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getShortName() : string
    {
        return $this->shortName;
    }

    public function isRequired() : bool
    {
        return $this->required;
    }

    public function isValueRequired() : bool
    {
        return $this->valueRequired;
    }
}
