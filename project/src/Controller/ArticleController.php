<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles/page/", defaults={"page" = "1"})
     * @Route("/articles/page/{page}", name="app_article")
     */
    public function index(ArticleRepository $articleRepository, int $page =1): Response
    {
        $page = $page ?? 1;

        $total = $articleRepository->countAll();
        $pageNumbers = [];
        $availablePages = ceil($total / 10);

        if ($page > 1) {
            for ($i = $page-1; $i< $page+2 && $i<=$availablePages; $i++) {
                $pageNumbers[] = $i;
            }
        } else {
            for ($i = $page; $i< $page+3 && $i<=$availablePages; $i++) {
                $pageNumbers[] = $i;
            }
        }

        $articles = $articleRepository->paginate($page);

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'total' => $total,
            'page' => $page,
            'availablePages' => $pageNumbers
        ]);
    }

    /**
     * @Route("/admin/article/{id}/delete", name="delete_article")
     */
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, ArticleRepository $articleRepository): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $em->remove($article);
        $em->flush();                  

        return new RedirectResponse('/articles/page/1');
    }
}
