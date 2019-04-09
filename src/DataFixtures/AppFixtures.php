<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('some@email.com')
            ->setActive(true)
            ->setPassword('helloPassword')
            ->setTermAccepted(true)
            ->setUsername('Dummy');

        $manager->persist($user);

        for ($iteration = 0;$iteration < 200; $iteration++) {
            $picture = new Picture();
            $picture->setMimeType('image/jpeg')
                ->setSharer($user)
                ->setDescription('Description number ' . $iteration)
                ->setTitle('Picture number ' . $iteration)
                ->setPath($iteration . '.tmp');

            $manager->persist($picture);

        }
        $manager->flush();
    }
}
