<?php


namespace App\Controller;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/{id}/favorite", name="article_favorite", methods={"GET","POST"})
     */
    public function favorite(Article $article, Request $request, ObjectManager $manager):Response
    {
        if ($this->getUser()->isFavorite($article)) {
            $this->getUser()->removeFavArticle($article);
        } else {
            $this->getUser()->addFavArticle($article);
        }
        $manager->flush();


        return $this->json([
            'isFavorite' => $this->getUser()->isFavorite($article)
        ]);
    }
}