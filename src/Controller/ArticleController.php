<?php

namespace App\Controller;

use App\Entity\Article;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticleRepository;

class ArticleController extends AbstractController {

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository){
        // return new Response('OMG! Its alive');
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, bool $isDebug, EntityManagerInterface $em){
        // return new Response(sprintf(
        //     'Some text of article: %s', $slug
        // ));

        dump($isDebug);

        $repository = $em->getRepository(Article::class);
        /** @var Article $article */
        $article = $repository->findOneBy(['slug' => $slug]);
        if(!$article){
            throw $this->createNotFoundException('Not found');
        }

        $comments = [
            'This is my comment',
            'Woo hoooo!!!',
            'Fuck off'
        ];

        dump($slug, $this);

        // get bundle configuration
        // php bin/console config:dump KnpMarkdownBundle

        // current configuration
        // php bin/console debug:config KnpMarkdownBundle

        // info about service (or dump the service)
        // php bin/console debug:container monolog.logger

        // show services in the container:
        // php bin/console debug:container

        // show filtered services in the container:
        // php bin/console debug:container log

        // show container parameters:
        // php bin/console debug:container --parameters

        // show all env vars
        // php bin/console about

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger){
        // TODO - actually heart/unheart article

        // list autowiring:
        // php bin/console debug:autowiring
        $logger->info('article is hearted');

        // return $this->json(['hearts' => rand(5,100)]);
        return new JsonResponse(['hearts' => rand(5,100)]);
    }
}