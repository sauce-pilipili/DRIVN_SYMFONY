<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

            $user = (new User())
                ->setEmail("moishadow@gmail.com")
                ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$eWxkVmFLZm12a0ZBc0J2Nw$+GqdPA7lNZ9m0KHSs5okotOwbvAZ9+UWTw73vqhpU9Y');
            $manager->persist($user);


        $date = new \DateTime('now');

        for ($i = 0; $i < 3 ; $i++ ){
            $categorie = (new Categories())
                ->setName("catégorie$i");
            $manager->persist($categorie);

            for ($j = 0; $j < 10 ; $j++ ){
                $article = (new Articles())
                    ->setTitle("article numero $j")
                    ->setCategorie($categorie)
                    ->setImageEnAvant('cocker-spaniel-2785074_1280.jpg')
                    ->setMetaDescription('meta description test')
                    ->setCreatedDate($date)
                    ->setContent("<p> bonjour nouvel article</p>")
                    ->setLegendeImageEnAvant('legende de l\'image');
                $manager->persist($article);
            }
        }
        $manager->flush();


        $manager->flush();


        $manager->flush();
    }
}
