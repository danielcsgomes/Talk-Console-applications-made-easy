<?php
// path/to/src/DCSG/Command/HelloWorldCommand.php
namespace DCSG\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AskAndValidateCommand extends Command
{
    protected function configure()
    {
        $this->setName('examples:dialog')
            ->setDescription('Ask and Validate Helper')
            ->addArgument('first_name', InputArgument::REQUIRED, 'Your first name')
            ->addArgument('last_name', InputArgument::REQUIRED, 'Your last name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $firstName = $input->getArgument('first_name');
        $lastName = $input->getArgument('last_name');

        $output->writeln("Your name is <info>{$firstName} {$lastName}</info>");
    }

    protected function interact(InputInterface $input, OutputInterface $output) {
        $firstName = $this->getHelper('dialog')->askAndValidate(
            $output,
            'Insert your first name: ',
            function ($firstName) {
                if (empty($firstName)) {
                    throw new \InvalidArgumentException('The first name cannot be empty.');
                }

                return $firstName;
            }
        );
        $input->setArgument('first_name', $firstName);

        $lastName = $this->getHelper('dialog')->askAndValidate(
            $output,
            'Insert your last name: ',
            function ($lastName) {
                if (empty($lastName)) {
                    throw new \InvalidArgumentException('The last name cannot be empty.');
                }

                return $lastName;
            }
        );
        $input->setArgument('last_name', $lastName);
    }
}

