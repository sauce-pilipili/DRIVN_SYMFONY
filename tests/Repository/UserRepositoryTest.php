<?php

namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserRepositoryTest extends WebTestCase
{

    public function testCount()
    {
        self::bootKernel();
        $container = self::$container;
        $em = $container->get('doctrine.orm.entity_manager');
        $users = $em->getRepository(User::class)->count([]);
        $this->assertEquals(10, $users);
    }
}