<?php declare(strict_types=1);
namespace Brzuchal\CommandLine;

class CommandLineBuilder
{
    /**
     * @var Parameter[]
     */
    private $parameters;

    public function withArgument(string $name, bool $required = false) : self
    {
        $this->parameters[$name] = new ArgumentDefinition($name, $required);

        return $this;
    }

    /** @noinspection MoreThanThreeArgumentsInspection */
    public function withOption(string $name, string $shortName, bool $required = false, bool $valueRequired = false) : self
    {
        $this->parameters[$name] = new OptionDefinition($name, $shortName, $required, $valueRequired, $required, $valueRequired);

        return $this;
    }

    public function build(array $parameters, string $cwd = null)
    {
        $definition = new CommandLineDefinition($this->parameters);
        $parser = new ArrayCommandLineParser($parameters, $cwd, $definition);

        return $parser->parse();
    }
}
