<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Service\imageUploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="articles_index", methods={"GET"})
     */
    public function index(Request $request,ArticlesRepository $articlesRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $titre = $request->get('text');
            $articles = $articlesRepository->findajaxArticles($titre);
            return new JsonResponse([
                'content' => $this->renderView('articles/_contentArticles.html.twig', compact('articles'))
            ]);
        }

        return $this->render('articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="articles_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, imageUploadService $imageService): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageService->add($form->get('imageEnAvant')->getData(), $article);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="articles_show", methods={"GET"})
     */
    public function show(Articles $article): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="articles_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Articles $article, EntityManagerInterface $entityManager, imageUploadService $imageService): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('imageEnAvant')->getData()) {
                if ($article->getImageEnAvant() != null) {

                    unlink($this->getParameter('images_directory') . '/' . $article->getImageEnAvant());
                }
                $imageService->add($form->get('imageEnAvant')->getData(), $article);
            }
            $entityManager->flush();

            return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="articles_delete", methods={"POST"})
     */
    public function delete(Request $request, Articles $article, EntityManagerInterface $entityManager): Response
    {
        $files = new Filesystem();
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            if ($article->getImageEnAvant() != null) {
                if ($files->exists($this->getParameter('images_directory') . '/' . $article->getImageEnAvant())){
                    unlink($this->getParameter('images_directory') . '/' . $article->getImageEnAvant());
                }
            }
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
    }
}
