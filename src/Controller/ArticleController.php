<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Michelf\MarkdownInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Cache\Adapter\AdapterInterface;
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
    public function show($slug, MarkdownInterface $markdown, AdapterInterface $cache){
        // return new Response(sprintf(
        //     'Some text of article: %s', $slug
        // ));

        $comments = [
            'This is my comment',
            'Woo hoooo!!!',
            'Fuck off'
        ];

        dump($slug, $this);

        // get bundle configuration
        // php bin/console config:dump KnpMarkdownBundle
        dump($markdown);

        $articleContent = <<<EOF
        Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
        lorem proident [beef ribs](https.www.beef.com) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
        labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
        **turkey** shank eu pork belly meatball non cupim.

        Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
        laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
        capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
        picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
        occaecat lorem meatball prosciutto quis strip steak.

        Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
        mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
        strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
        cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
        fugiat.
        EOF;

        $item = $cache->getItem('markdown_'.md5($articleContent));
        if(!$item->isHit()){
            $item->set($markdown->transform($articleContent));
            $cache->save($item);
        }
        $articleContent = $item->get();

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'articleContent' => $articleContent,
            'slug' => $slug,
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