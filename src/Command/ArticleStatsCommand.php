<?php

namespace App\Command;

use function GuzzleHttp\default_ca_bundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArticleStatsCommand extends Command
{
    protected static $defaultName = 'article:stats';

    protected function configure()
    {
        $this
            ->setDescription('Return some article stats!')
            ->addArgument('slug', InputArgument::OPTIONAL, 'Article slug')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'Output format', 'text')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $data = [
            'slug' => $slug,
            'hearts' => rand(10, 100),
        ];

        switch($input->getOption('format')) {
            case 'text':
                    $rows = [];
                    foreach($data as $key => $value) {
                        $rows[] = [$key, $value];
                    }
                    //$io->listing($data);
                    $io->table(['Key', 'Value'], $rows);
                break;
            case 'json':
                    $io->write(json_encode($data));
                break;
            default:
                throw new \Exception('Wrong fromat');
        }
    }
}
