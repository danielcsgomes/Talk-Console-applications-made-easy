<?php
// path/to/src/DCSG/Command/HelloWorldCommand.php
namespace DCSG\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProgressHelperCommand extends Command
{
    protected function configure()
    {
        $this->setName('examples:progress')
            ->setDescription('Progress Helper example');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $progress = $this->getHelperSet()->get('progress');

        $progress->start($output, 10);

        $i = 0;
        while ($i++ < 10) {
            sleep(1);
            $progress->advance();
        }

        $progress->finish();
    }
}

