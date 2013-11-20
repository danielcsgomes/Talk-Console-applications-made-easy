<?php

namespace DCSG\Tests;

use DCSG\Command\HelloWorldCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class HelloWorldCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testOutputName()
    {
        $application = new Application();
        $application->add(new HelloWorldCommand());

        $command = $application->find('hello:world');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                 'command' => $command->getName(),
                 'name' => 'Daniel'
            )
        );

        $this->assertRegExp('/Daniel/', $commandTester->getDisplay());
    }

    public function testOutputNameInUppercase()
    {
        $command = new HelloWorldCommand();
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                 'command' => $command->getName(),
                 'name' => 'Daniel',
                 '--uppercase' => true,
            )
        );

        $this->assertRegExp('/DANIEL/', $commandTester->getDisplay());
    }
}
