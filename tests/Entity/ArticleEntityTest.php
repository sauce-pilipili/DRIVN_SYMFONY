<?php

namespace App\Tests\Entity;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleEntityTest extends KernelTestCase
{
    public function testValidArticle()
    {
    $article = (new Articles())
        ->setTitle('Mon article de test')
        ->setImageEnAvant('ok.jpg')
        ->setLegendeImageEnAvant('legende de test ok ');

    self::bootKernel();
    $container = self::getContainer();
    $error = $container->get('validator')->validate($article);
    $this->assertCount(0,$error);
    }

}