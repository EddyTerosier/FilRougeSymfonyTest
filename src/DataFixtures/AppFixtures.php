<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Programmes;
use App\Entity\User;
use App\Entity\Mark;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create("fr_FR");
    }
    public function load(ObjectManager $manager): void
    {
        $number = 0;
        $programmes = [];
        for ($i = 1; $i <= 3; $i++) {
            $number++;
            $programme = new Programmes();
            $programme
                ->setName("Débutant")
                ->setDescription(
                    "Some quick example text to build on the card title and make up the bulk of the card's content."
                )
                ->setImage("./assets/img/Carousel-" . $number . ".jpg");

            $programmes[] = $programme;
            $manager->persist($programme);
        }
        // $programmes = [];
        // $programme = new Programmes();
        // $programme->setName('Débutant')
        //     ->setDescription("Some quick example text to build on the card title and make up the bulk of the card's content.")
        //     ->setImage('./assets/img/Carousel-1.jpg');
        // $programme2 = new Programmes();
        // $programme2->setName('Intermédiaire')
        //     ->setDescription("Some quick example text to build on the card title and make up the bulk of the card's content.")
        //     ->setImage('./assets/img/Carousel-3.jpg');
        // $programme3 = new Programmes();
        // $programme3->setName('Expert')
        //     ->setDescription("Some quick example text to build on the card title and make up the bulk of the card's content.")
        //     ->setImage('./assets/img/Carousel-2.jpg');

        // $programmes[] = [$programme, $programme2, $programme3];
        // $manager->persist($programme);
        // $manager->persist($programme2);
        // $manager->persist($programme3);

        // Users
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setEmail($this->faker->email())
                ->setRoles(["ROLE_USER"])
                ->setPlainPassword("password");
            $users[] = $user;
            $manager->persist($user);
        }

        // Marks
    //     foreach ($programmes as $programme) {
    //         for ($i = 0; $i < mt_rand(0, 4); $i++) {
    //             $mark = new Mark();
    //             $mark
    //                 ->setMark(mt_rand(1, 5))
    //                 ->setUser($users[mt_rand(0, count($users) - 1)])
    //                 ->setProgrammes($programme);
    //             $manager->persist($mark);
    //         }
    //     }

    // FORMULAIRE CONTACT
    for ($i=0; $i < 5; $i++) { 
        $contact = new Contact();
        $contact->setFirstName($this->faker->firstName())
        ->setLastName($this->faker->lastName())
        ->setEmail($this->faker->email())
        ->setSubject("Demande n°" . ($i +1))
        ->setMessage($this->faker->text());

        $manager->persist($contact);
    }

    $manager->flush();
    }
}
