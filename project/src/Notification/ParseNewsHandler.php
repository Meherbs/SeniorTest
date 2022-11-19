<?php

namespace App\Notification;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Article;
use App\Service\ParsingService;
use Psr\Log\LoggerInterface;

class ParseNewsHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private ArticleRepository $articleRepository;
    private ParsingService $parserService;
    protected LoggerInterface $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger,ParsingService $parserService, ArticleRepository $articleRepository)
    {
        $this->logger = $logger;
        $this->parserService = $parserService;
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
    }

    public function __invoke(ParseNews $newsApi)
    {
        $news = $this->parserService->parse($newsApi->getUrl());

        //$this->logger->info('----- invoke ----');
       
        $this->logger->info('---- after news -----');
        foreach ($news as $data) {
            $this->logger->info('----- data title ----');
            $this->logger->info(json_encode($data['title']));
            // get articles by title
            $articles = $this->articleRepository->findBy(['title' => $data['title']]);

            if (empty($articles)) {
                // the article is not existed on DB
                $article = new Article();
                $article->setTitle($data['title']);
                $article->setDescription(substr($data['description'], 0, 255) ?? null);
                $article->setPicture($data['urlToImage'] ?? null);
                $article->setCreatedAt(new \DateTimeImmutable($data['publishedAt']));
                $article->setLastUpdatedAt(new \DateTimeImmutable('now'));
                
                $this->entityManager->persist($article);
                $this->entityManager->flush();
            }
        }
    }
}