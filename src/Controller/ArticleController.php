<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ArticleController {

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
        return new Response(sprintf(
            'Some text of article: %s', $slug
        ));
    }
}