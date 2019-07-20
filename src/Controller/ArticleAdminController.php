<?php


namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/admin", name="admin_")
 */
class ArticleAdminController extends AbstractController
{

    /**
     *
     * @Route("/articles", name="articles")
     */
    public function allArticles():Response
    {
        $articlesRepo = $this->getDoctrine()->getManager()->getRepository(Article::class);
        $articles = $articlesRepo->findAll();

        return $this->render('Backend/ArticleAdmin/allTravels.html.twig',['articles' => $articles]);
    }

    /**
     *
     * @Route("/categorie/{categoryId}/articles" , name="articles_by_cate")
     */
    public function articlesBy($categoryId):Response
    {
        $articlesRepo = $this->getDoctrine()->getManager()->getRepository(Article::class);
        $articles = $articlesRepo->findBy(['category' => $categoryId]);

        return $this->render('Backend/ArticleAdmin/allTravels.html.twig',['articles' => $articles]);
    }

    /**
     * @Route("/article/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setAuthor($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Un article vient d\'être ajouté' );

            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('Backend\ArticleAdmin\form.html.twig', [
            'article' => $article,
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $this->denyAccessUnlessGranted('EDIT', $article);

        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Article modifié' );

            return $this->redirectToRoute('admin_articles', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('Backend\ArticleAdmin\form.html.twig', [
            'article' => $article,
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}/delete", name="article_delete")
     */
    public function delete(Request $request, Article $article): Response
    {
        $this->denyAccessUnlessGranted('DELETE', $article);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('danger', 'Article supprimé !' );

        return $this->redirectToRoute('admin_articles');
    }

}