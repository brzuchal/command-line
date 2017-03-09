<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

class Option implements Parameter
{
    /**
     * @var string Holds option name
     */
    protected $name;
    /**
     * @var string|bool Holds option value
     */
    protected $value;

    public function __construct(string $name, $value = false)
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
