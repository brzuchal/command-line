<?php
use Brzuchal\CommandLine\ArgumentDefinition;
use Brzuchal\CommandLine\CommandLineDefinition;
use Brzuchal\CommandLine\OptionDefinition;

class CommandLineDefinitionTest extends \PHPUnit\Framework\TestCase
{
    public function testCreationWithArgument()
    {
        $argument = new ArgumentDefinition('test', 1);
        $definition = new CommandLineDefinition([$argument]);
        $this->assertTrue($definition->hasArgumentDefinition('test'));
        $this->assertEquals($argument, $definition->getArgumentDefinition('test'));
        $this->assertEquals($argument, $definition->getArgumentDefinitionAtPosition(0));
    }

    public function testCreationWithTwoArguments()
    {
        $argument1 = new ArgumentDefinition('arg1', 1);
        $argument2 = new ArgumentDefinition('arg2', 1);
        $definition = new CommandLineDefinition([$argument1, $argument2]);
        $this->assertTrue($definition->hasArgumentDefinition('arg1'));
        $this->assertTrue($definition->hasArgumentDefinition('arg2'));
        $this->assertEquals($argument1, $definition->getArgumentDefinition('arg1'));
        $this->assertEquals($argument2, $definition->getArgumentDefinition('arg2'));
        $this->assertEquals($argument1, $definition->getArgumentDefinitionAtPosition(0));
        $this->assertEquals($argument2, $definition->getArgumentDefinitionAtPosition(1));
    }

    public function testCreationWithOption()
    {
        $option = new OptionDefinition('help', 'h');
        $definition = new CommandLineDefinition([$option]);
        $this->assertTrue($definition->hasOptionDefinition('help'));
        $this->assertTrue($definition->hasOptionDefinition('h'));
        $this->assertEquals($option, $definition->getOptionDefinition('help'));
        $this->assertEquals($option, $definition->getOptionDefinition('h'));
    }

    public function testCreationWithTwoOptions()
    {
        $option1 = new OptionDefinition('help', 'h');
        $option2 = new OptionDefinition('version', 'v');
        $definition = new CommandLineDefinition([$option1, $option2]);
        $this->assertTrue($definition->hasOptionDefinition('help'));
        $this->assertTrue($definition->hasOptionDefinition('h'));
        $this->assertTrue($definition->hasOptionDefinition('version'));
        $this->assertTrue($definition->hasOptionDefinition('v'));
        $this->assertEquals($option1, $definition->getOptionDefinition('help'));
        $this->assertEquals($option1, $definition->getOptionDefinition('h'));
        $this->assertEquals($option2, $definition->getOptionDefinition('version'));
        $this->assertEquals($option2, $definition->getOptionDefinition('v'));
    }

    public function testCreationWithArgumentsAndOptions()
    {
        $argument1 = new ArgumentDefinition('arg1', 1);
        $argument2 = new ArgumentDefinition('arg2', 1);
        $option1 = new OptionDefinition('help', 'h');
        $option2 = new OptionDefinition('version', 'v');
        $definition = new CommandLineDefinition([$argument1, $argument2, $option1, $option2]);
        $this->assertTrue($definition->hasArgumentDefinition('arg1'));
        $this->assertTrue($definition->hasArgumentDefinition('arg2'));
        $this->assertEquals($argument1, $definition->getArgumentDefinition('arg1'));
        $this->assertEquals($argument2, $definition->getArgumentDefinition('arg2'));
        $this->assertEquals($argument1, $definition->getArgumentDefinitionAtPosition(0));
        $this->assertEquals($argument2, $definition->getArgumentDefinitionAtPosition(1));
        $this->assertTrue($definition->hasOptionDefinition('help'));
        $this->assertTrue($definition->hasOptionDefinition('h'));
        $this->assertTrue($definition->hasOptionDefinition('version'));
        $this->assertTrue($definition->hasOptionDefinition('v'));
        $this->assertEquals($option1, $definition->getOptionDefinition('help'));
        $this->assertEquals($option1, $definition->getOptionDefinition('h'));
        $this->assertEquals($option2, $definition->getOptionDefinition('version'));
        $this->assertEquals($option2, $definition->getOptionDefinition('v'));
    }
}
