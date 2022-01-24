<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Constraint\FileExists;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="categories_index", methods={"GET"})
     */
    public function index(Request $request, CategoriesRepository $categoriesRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $name = $request->get('text');
            $categories = $categoriesRepository->findajaxCategories($name);
            return new JsonResponse([
                'content' => $this->renderView('categories/_contentCategorie.html.twig', compact('categories'))
            ]);
        }

        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="categories_show", methods={"GET"})
     */
    public function show(Categories $category): Response
    {
        return $this->render('categories/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categories $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="categories_delete", methods={"POST"})
     */
    public function delete(Request $request, Categories $category, EntityManagerInterface $entityManager, ArticlesRepository $articlesRepository): Response
    {
        $files = New Filesystem();
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $imageToDelete = $articlesRepository->findBy(['Categorie'=>$category]);
            foreach ($imageToDelete as $image){
                if ($files->exists($this->getParameter('images_directory') . '/' . $image->getImageEnAvant())){
                    unlink($this->getParameter('images_directory') . '/' . $image->getImageEnAvant());
                }
            }
            $entityManager->remove($category);
            $entityManager->flush();
        }
        return $this->redirectToRoute('categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
