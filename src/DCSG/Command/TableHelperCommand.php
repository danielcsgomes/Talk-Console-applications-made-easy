<?php
// path/to/src/DCSG/Command/HelloWorldCommand.php
namespace DCSG\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TableHelperCommand extends Command
{
    protected function configure()
    {
        $this->setName('helpers:table')
            ->setDescription('Table Helper example');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = $this->getHelperSet()->get('table');
        $table
            ->setHeaders(array('Color', 'HEX'))
            ->setRows(
                array(
                     array('Red', '#ff0000'),
                     array('Blue', '#0000ff'),
                     array('Green', '#008000'),
                     array('Yellow', '#ffff00')
                )
            );
        $table->render($output);
    }
}

