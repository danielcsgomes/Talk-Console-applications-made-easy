<?php
// path/to/src/DCSG/Command/HelloWorldCommand.php
namespace DCSG\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CallingCommandInsideCommand extends Command
{
    protected function configure()
    {
        $this->setName('example:calling:command')
            ->setDescription('Example of calling a Command inside another Command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getApplication()->find('hello:world');

        $arguments = array(
            'command' => 'hello:world',
            'name' => 'Daniel Gomes'
        );

        $returnCode = $command->run(new ArrayInput($arguments), $output);
        $output->writeln("Exit code $returnCode");
    }
}

