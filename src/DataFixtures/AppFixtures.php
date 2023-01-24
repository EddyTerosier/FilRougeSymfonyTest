<?php

namespace App\DataFixtures;

use App\Entity\Programmes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $programme = new Programmes();
        $programme->setName('Débutant')
            ->setDescription("Some quick example text to build on the card title and make up the bulk of the card's content.")
            ->setImage('./assets/img/Carousel-1.jpg');
        $programme2 = new Programmes();
        $programme2->setName('Intermédiaire')
            ->setDescription("Some quick example text to build on the card title and make up the bulk of the card's content.")
            ->setImage('./assets/img/Carousel-3.jpg');
        $programme3 = new Programmes();
        $programme3->setName('Expert')
            ->setDescription("Some quick example text to build on the card title and make up the bulk of the card's content.")
            ->setImage('./assets/img/Carousel-2.jpg');

        $manager->persist($programme);
        $manager->persist($programme2);
        $manager->persist($programme3);
        $manager->flush();
    }
}
