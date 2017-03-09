PHP CommandLine argument and option parser
==========================================

Purpose of this project is to provide modern and complete API for command line argument and option parsing in CLI.

## CommandLine generics

When you type `ENV=prod php -d "error_reporting=E_ALL" script.php test --debug` only last command line components are visible
in `script.php` scope at runtime.

Following analysis such command line consists of:

```
ENV=prod                   // this is shell way for setting environment variables per process
php                        // this part is pointing to php interpreter
-d "error_reporting=E_ALL" // this part holds php interpreter options
script.php                 // visible at runtime script filename
test                       // visible at runtime arguments
--debug                    // visible at runtime options
```

Runtime command line generic components are: `command` + `arguments` + `options`.


## Examples

The simplest way to retrieve parameters from CLI with definitions:

```php
$commandLine = (new \Brzuchal\CommandLine\CommandLineBuilder())
    ->withArgument('command')
    ->withOption('file', 'f')
    ->withOption('count', 'c', true)
    ->build($_SERVER['argv'], $_SERVER['PWD']);
```

The simplest way to retrieve parameters from CLI without definition:

```php
$parser = new \Brzuchal\CommandLine\ArrayCommandLineParser($_SERVER['argv']);
$commandLine = $parser->parse();
```

Which for `php test.php command --env=prod --debug -f -c` gives:

```
PHP\CLI\CommandLine Object
(
    [command:protected] => test.php
    [parameters:protected] => Array
        (
            [0] => PHP\CLI\Argument Object
                (
                    [name:protected] => arg0
                    [value:protected] => command
                )

            [1] => PHP\CLI\Option Object
                (
                    [name:protected] => env
                    [value:protected] => prod
                )

            [2] => PHP\CLI\Option Object
                (
                    [name:protected] => debug
                    [value:protected] => 
                )

            [3] => PHP\CLI\Option Object
                (
                    [name:protected] => f
                    [value:protected] => 
                )

            [4] => PHP\CLI\Option Object
                (
                    [name:protected] => c
                    [value:protected] => 1
                )

        )

    [cwd:protected] => /home/brzuchal/Workspace/command-line
)
```

There is also a way to retrieve parameters with it's definitions and their requirements:

```php
$definition = new \Brzuchal\CommandLine\Definition([
    new \Brzuchal\CommandLine\ArgumentDefinition('command'),
    new \Brzuchal\CommandLine\OptionDefinition('env', 'e'),
    new \Brzuchal\CommandLine\OptionDefinition('file', 'f'),
    new \Brzuchal\CommandLine\OptionDefinition('count', 'c'),
]);
$parser = new \Brzuchal\CommandLine\ArrayParameterParser($_SERVER['argv']);
$parameters = $parser->parse();
```

Which also validates if options have values and are required.
Parsing command `php test.php command --env=prod --debug -f -c` gives:

```
PHP\CLI\CommandLine Object
(
    [command:protected] => test.php
    [parameters:protected] => Array
        (
            [0] => PHP\CLI\Argument Object
                (
                    [name:protected] => command
                    [value:protected] => command
                )

            [1] => PHP\CLI\Option Object
                (
                    [name:protected] => env
                    [value:protected] => prod
                )

            [2] => PHP\CLI\Option Object
                (
                    [name:protected] => debug
                    [value:protected] => 
                )

            [3] => PHP\CLI\Option Object
                (
                    [name:protected] => file
                    [value:protected] => 
                )

            [4] => PHP\CLI\Option Object
                (
                    [name:protected] => count
                    [value:protected] => 1
                )

        )

    [cwd:protected] => /home/brzuchal/Workspace/command-line
)
```

## TODO

* [x] Parse options from array
* [ ] Parse options from string
* [ ] Validates required values
* [ ] Provide default values
* [x] Parse arguments from array
* [ ] Parse arguments from string
* [ ] Validates existence of arguments

## License

The MIT License (MIT)

Copyright (c) 2017 Michał Brzuchalski <michal.brzuchalski@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OFc MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
