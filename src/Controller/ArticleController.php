<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController {

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(){
        // return new Response('OMG! Its alive');
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug){
        // return new Response(sprintf(
        //     'Some text of article: %s', $slug
        // ));

        $comments = [
            'This is my comment',
            'Woo hoooo!!!',
            'Fuck off'
        ];

        dump($slug, $this);

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug){
        // TODO - actually heart/unheart article

        // return $this->json(['hearts' => rand(5,100)]);
        return new JsonResponse(['hearts' => rand(5,100)]);
    }
}