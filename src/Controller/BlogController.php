<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\Comment;
use App\Form\UserComment;
use App\Repository\ArticleLikeRepository;
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
        return $this->render('Blog/allTravels.html.twig',['articles' =>  $articleRepository->findAllArticlesAndUsingTags()]);
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


    /**
     * @Route ("/article/{id}/like", name="article_like")
     *
     * Permet de liker ou unliker un article
     * @param Article               $article
     * @param ObjectManager         $manager
     * @param ArticleLikeRepository $likeRepository
     *
     * @return Response
     */
    public function like(Article $article, ObjectManager $manager, ArticleLikeRepository $likeRepository) : Response
    {
        $user = $this->getUser();

        if(!$user) {
            return $this->json(['code' => 403, 'message' => 'Unauthorized'], 403);
        }



        if ($article->isLikeByUser($user)) {
            $like = $likeRepository->findOneBy(['article' => $article, 'user' => $user]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepository->count(['article' => $article])
            ], 200);
        }

        $like = new ArticleLike();
        $like->setArticle($article)->setUser($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $likeRepository->count(['article' => $article])
            ], 200);
    }


}