<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

class Argument implements Parameter
{
    /**
     * @var string Holds argument name
     */
    protected $name;
    /**
     * @var mixed Holds argument value
     */
    protected $value;

    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName() : string
    {
        return $this->name;
    }
    
    public function hasValue() : bool
    {
        return !empty($this->value);
    }

    public function getValue() : ?string
    {
        return $this->value;
    }
}
