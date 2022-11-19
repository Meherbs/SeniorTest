<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Notification\ParseNews;
use Symfony\Component\Messenger\MessageBusInterface;
use \DateTime;
use Psr\Log\LoggerInterface;

class ParserCommand extends Command
{
    protected static $defaultName = 'app:parse-news';

    protected MessageBusInterface $bus;

    protected LoggerInterface $logger;

    public function __construct(MessageBusInterface $bus, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->bus = $bus;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $datetime = new DateTime('now');
        $dateTo = $datetime->format(DateTime::ATOM);
        $datetime->modify('-30 days');
        $dateFrom = $datetime->format(DateTime::ATOM);

        $this->logger->info('I just got the logger');
        $this->logger->info('date From '.$dateFrom.'  date To ==  '.$dateTo);

        $url = "https://newsapi.org/v2/everything?q=a&apiKey=__news_api_key__&from=".$dateFrom."&to=".$dateTo;
       
        $this->logger->info('url');
        $this->logger->info($url);

        $this->bus->dispatch(new ParseNews($url));
        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;
    }
}