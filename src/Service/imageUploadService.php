<?php

namespace App\Service;

use App\Entity\Articles;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class imageUploadService
{
    private ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add($image, Articles $article)
    {
        // On boucle sur les images
        // On génère un nouveau nom de fichier
        $fichier = md5(uniqid()) . '.' . $image->guessExtension();
        // On copie le fichier dans le dossier uploads
        $image->move(
            $this->params->get('images_directory'),
            $fichier
        );
        // On crée l'image dans la base de données
        $article->setImageEnAvant($fichier);
    }
}