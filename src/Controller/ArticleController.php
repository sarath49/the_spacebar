<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class ArticleController extends AbstractController{

        /**
         * @Route("/", name="app_homepage")
         */
        public function homepage() {
            return $this->render('article/homepage.html.twig');
        }

        /**
         * @Route("/news/{slug}", name="app_show")
         */
        public function show($slug, SlackClient $slack, EntityManagerInterface $em) {

            if ($slug == 'khan') {
                $slack->sendMessage('Khan', 'Hi friend');
            }

            $comments = [
                'I ate a normal rock once. It did NOT taste like bacon!',
                'Woohoo! I\'m going on an all-asteroid diet!',
                'I like bacon too! Buy some from my site! bakinsomebacon.com',
            ];

            $repository = $em->getRepository(Article::class);

            /** @var Article $article */
            $article = $repository->findOneBy(['slug' => $slug]);

            if (!$article) {
                throw $this->createNotFoundException(sprintf('Article with "%s" not found', $slug));
            }


            //$articleContent = $markdownHelper->parse($articleContent);
            return $this->render('article/show.html.twig', [
                'article' => $article,
                'comments' => $comments
            ]);
        }

        /**
         * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
         */
        public function toggleArticleHeart($slug, LoggerInterface $logger) {

            // TODO - actually heart/unheart the article!

            $logger->info('Article hearts clicked');

            return $this->json(['hearts' => rand(5, 100)]);
        }
}