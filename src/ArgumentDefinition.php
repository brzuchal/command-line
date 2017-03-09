<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

class ArgumentDefinition implements ParameterDefinition
{
    /**
     * @var string Holds argument name
     */
    protected $name;
    /**
     * @var bool Holds argument existence requirement
     */
    protected $required;

    public function __construct(string $name, bool $required = false)
    {
        $this->name = $name;
        $this->required = $required;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function isRequired() : bool
    {
        return $this->required;
    }
}
