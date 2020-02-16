<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController {

    /**
     * @Route("/")
     */
    public function homepage(){
        return new Response('OMG! Its alive');
    }

    /**
     * @Route("/news/{slug}")
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
            'comments' => $comments
        ]);
    }
}