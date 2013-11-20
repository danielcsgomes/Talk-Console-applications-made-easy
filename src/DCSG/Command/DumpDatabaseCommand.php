<?php
/**
 * This file is part of the examples package.
 *
 * (c) Daniel Gomes <me@danielcsgomes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DCSG\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpDatabaseCommand extends Command
{
    private $host;
    private $dbnames;
    private $user;
    private $password;

    protected function configure()
    {
        $this
            ->setName('database:dump')
            ->setDescription('Dump the database.')
            ->addOption('skip-lock-tables')
            ->addOption('add-drop-database')
            ->addOption('add-drop-table')
            ->setHelp(
                'The <info>database:dump</info> will dump all tables.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mysqldump = $this->composeExecCommand($this->getOptions($input));

        $exitCode = 0;
        $execOutput = array();
        exec($mysqldump, $execOutput, $exitCode);

        if (0 === $exitCode) {
            $message = "<info>Success</info>";
        } else {
            $message = "<error>Error with exit code: {$exitCode}";
        }

        $output->writeln($message);
    }

    /**
     * Creates the command to be executed
     *
     * @param string $options
     * @return string
     */
    private function composeExecCommand($options)
    {
        $filename = $this->getFilename();

        $dbUser = $this->user;
        $dbPassword = $this->password;
        $dbHost = $this->host;
        $dbNames = $this->dbnames;

        return <<<EOF
mysqldump -u{$dbUser} -p{$dbPassword} -h{$dbHost} {$options} --databases {$dbNames} > {$filename}
EOF;
    }

    /**
     * Gets and creates in case does not exists the file
     *
     * @return string
     */
    private function getFilename()
    {
        $filename = sprintf(
            '%s/tmp/dump_%s.sql',
            __DIR__ . '/../../../',
            date('d-m-Y_hs')
        );

        if (!file_exists($filename)) {
            touch($filename);
        }

        return $filename;
    }

    private function getOptions(InputInterface $input)
    {
        $options = [];

        if ($input->hasOption('add-drop-database')) {
            $options[] = '--add-drop-database';
        }
        if ($input->hasOption('add-drop-table')) {
            $options[] = '--add-drop-table';
        }
        if ($input->hasOption('skip-lock-tables')) {
            $options[] = '--skip-lock-tables';
        }

        return implode(' ', $options);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $isEmpty = function($value) {
            if (empty($value)) {
                throw new \InvalidArgumentException('Value cannot be empty.');
            }

            return $value;
        };

        $dialog = $this->getHelper('dialog');

        $this->host = $dialog->askAndValidate($output, 'host: ', $isEmpty);
        $this->user = $dialog->askAndValidate($output, 'username: ', $isEmpty);
        $this->password = $dialog->askAndValidate($output, 'password: ', $isEmpty);
        $this->dbnames = $dialog->askAndValidate($output, 'databases separate by space: ', $isEmpty);
    }
}
