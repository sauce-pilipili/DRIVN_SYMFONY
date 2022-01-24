<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteMapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request, ArticlesRepository $articlesRepository): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        $urls = [];

        // On ajoute les URLs "statiques"
        $urls[] = ['loc' => $this->generateUrl('index')];
        $urls[] = ['loc' => $this->generateUrl('blog',['categorie'=> 'tous'])];
        $urls[] = ['loc' => $this->generateUrl('contact')];
        $urls[] = ['loc' => $this->generateUrl('dashboard')];
        $urls[] = ['loc' => $this->generateUrl('solution_1')];
        $urls[] = ['loc' => $this->generateUrl('tarif')];
        $urls[] = ['loc' => $this->generateUrl('tarif_annuel')];
        $urls[] = ['loc' => $this->generateUrl('legals')];
        $urls[] = ['loc' => $this->generateUrl('faq')];
        $urls[] = ['loc' => $this->generateUrl('merci')];
        $urls[] = ['loc' => $this->generateUrl('partenariat')];
        $urls[] = ['loc' => $this->generateUrl('demo')];



//        articles
        $articles = $articlesRepository->findAll();
        foreach ($articles as $article) {
            $images = [
                'loc' => '/uploads/'.$article->getImageEnAvant(), // URL to image
                'title' => $article->getTitle()    // Optional, text describing the image
            ];

            $urls[] = [
                'loc' => $this->generateUrl('article', [
                    'slug' => $article->getSlug(),
                ]),
                'image' => $images
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );

// Ajout des entêtes
        $response->headers->set('Content-Type', 'text/xml');

// On envoie la réponse
        return $response;
    }
}
