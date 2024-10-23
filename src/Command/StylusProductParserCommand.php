<?php

namespace App\Command;

use App\Service\Parser\StylusProductParser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:stylus:product:parser',
    description: 'Parse product from stylus url',
)]
class StylusProductParserCommand extends Command
{
    public function __construct(private readonly StylusProductParser $stylusProductParser)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Parse product from stylus url');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stylusUrls = [
            'https://stylus.ua/uk/smartfony/',
            'https://stylus.ua/uk/televizory/',
            'https://stylus.ua/uk/noutbuki/'
        ];

        foreach ($stylusUrls as $url) {
            $this->stylusProductParser->createProductsFromUrl($url);
        }

        return Command::SUCCESS;
    }
}
