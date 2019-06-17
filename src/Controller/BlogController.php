<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\UserComment;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 *
 * @Route(name="app_")
 */
class BlogController extends AbstractController
{
    /**
     *
     * @Route("/", name="index")
     */
    public function index():Response
    {
        return $this->render('Home/index.html.twig');
    }

    /**
     *
     * @Route("/tous-mes-voyages", name="all_travels")
     */
    public function showAllTravels(ArticleRepository $articleRepository):Response
    {
        return $this->render('Blog/allTravels.html.twig',['articles' =>  $articleRepository->findAll()]);
    }

    /**
     *
     * @Route("/mon-voyage/{id}", name="travel")
     */
    public function showTravel(Article $article, Request $request, ObjectManager $manager):Response
    {
        $comment = new Comment();
        $form = $this->createForm(UserComment::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setDate(new \DateTime())
                    ->setArticle($article)
                    ->setUser($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('app_travel', ['id' => $article->getId()]);
        }

        return $this->render('Blog/travel.html.twig',[
            'article' => $article,
            'commentForm' => $form->createView(),
        ]);
    }
}