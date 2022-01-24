<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Form\DemoType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use App\Service\mailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request            $request,
                          ArticlesRepository $articlesRepository,
                          mailerService    $mailer): Response
    {
        $formDemo = $this->createForm(DemoType::class);
        $this->formDemoSend($request, $formDemo, $mailer);

        $lastArticles = $articlesRepository->findLastOne();
        return $this->render('main/index.html.twig', [
            'articles' => $lastArticles,
            'formDemo' => $formDemo->createView(),
            'formDemo1' => $formDemo->createView(),
        ]);
    }

    /**
     * @Route("/actualite/{categorie}", name="blog")
     */
    public function blog(Request              $request,
                                              $categorie,
                         CategoriesRepository $categoriesRepository,
                         ArticlesRepository   $articlesRepository,
                         mailerService    $mailer): Response
    {
        $formDemo = $this->createForm(DemoType::class);
        $this->formDemoSend($request, $formDemo, $mailer);

        if ($categorie == "tous") {
            $articles = $articlesRepository->findAll();
        } else {
            $cat = $categoriesRepository->findOneBy(['Name' => $categorie]);
            $articles = $articlesRepository->findBy(["Categorie" => $cat->getId()]);
        }
        $categories = $categoriesRepository->findAll();

        return $this->render('main/blog.html.twig', [
            'categories' => $categories,
            'articles' => $articles,
            'formDemo' => $formDemo->createView()
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article")
     */
    public function article(Request            $request,
                                               $slug,
                            ArticlesRepository $articlesRepository,
                            mailerService    $mailer): Response
    {
        $formDemo = $this->createForm(DemoType::class);
        $this->formDemoSend($request, $formDemo, $mailer);

        $lastArticles = $articlesRepository->findLastOne();
        $article = $articlesRepository->findOneBy(['slug' => $slug]);
        return $this->render('main/article.html.twig', [
            'article' => $article,
            'articles' => $lastArticles,
            'formDemo' => $formDemo->createView(),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, mailerService $mailer): Response
    {
        //contact form
        $form = $this->createForm(ContactFormType::class);
        $this->formContactSend($request, $form, $mailer);
        //demo form
        $formDemo = $this->createForm(DemoType::class);
        $this->formDemoSend($request, $formDemo, $mailer);

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
            'formDemo' => $formDemo->createView(),
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('main/dashboard.html.twig');
    }


    /**
     * @Route("/solution/1", name="solution_1")
     */
    public function solutionUn(Request $request,
                               mailerService    $mailer): Response
    {
        $formDemo = $this->createForm(DemoType::class);
        $this->formDemoSend($request, $formDemo, $mailer);
        return $this->render('main/solution1.html.twig', [
            'formDemo1' => $formDemo->createView(),
            'formDemo2' => $formDemo->createView(),
        ]);
    }

    /**
     * @Route("/tarif", name="tarif")
     */
    public function tarif(Request $request,
                          mailerService    $mailer): Response
    {
        $formDemo = $this->createForm(DemoType::class);
        $this->formDemoSend($request, $formDemo, $mailer);
        return $this->render('main/tarif.html.twig', [
            'formDemo' => $formDemo->createView()]);
    }

    /**
     * @Route("/tarif-annuel", name="tarif_annuel")
     */
    public function tarifAnnuel(Request $request,
                                mailerService    $mailer): Response
    {
        $formDemo = $this->createForm(DemoType::class);
        $this->formDemoSend($request, $formDemo, $mailer);
        return $this->render('main/tarifAnnuel.html.twig', [
            'formDemo' => $formDemo->createView()]);
    }

    /**
     * @Route("/mention/legales", name="legals")
     */
    public function legals(): Response
    {
        return $this->render('main/legals.html.twig');
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(): Response
    {
        return $this->render('main/faq.html.twig');
    }

    /**
     * @Route("/merci", name="merci")
     */
    public function merci(): Response
    {
        return $this->render('main/merci.html.twig');
    }

    /**
     * @Route("/partenariat", name="partenariat")
     */
    public function partenariat(): Response
    {
        return $this->render('main/partenariat.html.twig');
    }

    /**
     * @Route("/demo", name="demo")
     */
    public function demo(Request $request,
                         mailerService    $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $this->formDemoSend($request, $form, $mailer);

        return $this->render('main/demo.html.twig', [
            'form' => $form->createView(),
        ]);
    }

//    ******************************************************************************************************************************
    public function formDemoSend(Request $request, $form, mailerService $mailer)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mailer->sendDemoMail(
                $form->get('email')->getData());
        }
    }


    public function formContactSend(Request $request, $form, mailerService $mailer)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mailer->sendMail(
                $form->get('email')->getData(),
                $form->get('name')->getData(),
                $form->get('message')->getData());
        }
    }
}
