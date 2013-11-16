<?php
// path/to/src/DCSG/Command/HelloWorldCommand.php
namespace DCSG\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FormatterHelperCommand extends Command
{
    protected function configure()
    {
        $this->setName('helpers:formatter')
            ->setDescription('Formatter Helper examples');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelperSet()->get('formatter');

        $formattedLine = $formatter->formatSection(
            'SomeSection',
            'Here is some message related to that section'
        );
        $output->writeln($formattedLine);

        $msg = array('Something went wrong');
        $formattedBlock = $formatter->formatBlock($msg, 'error');
        $output->writeln($formattedBlock);

        $msg = array('Custom Colors');
        $formattedBlock = $formatter->formatBlock($msg, 'bg=blue;fg=white');
        $output->writeln($formattedBlock);
    }
}
