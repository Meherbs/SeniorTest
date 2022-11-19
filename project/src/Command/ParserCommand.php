<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Notification\ParseNews;
use Symfony\Component\Messenger\MessageBusInterface;
use \DateTime;

class ParserCommand extends Command
{
    protected static $defaultName = 'app:parse-news';

    protected MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $datetime = new DateTime('now');
        $dateTo = $datetime->format(DateTime::ATOM);
        $datetime->modify('-30 days');
        $dateFrom = $datetime->format(DateTime::ATOM);

        $url = "https://newsapi.org/v2/everything?q=a&apiKey=__news_api_key__&from=".$dateFrom."&to=".$dateTo;

        $this->bus->dispatch(new ParseNews($url));

        return Command::SUCCESS;
    }
}