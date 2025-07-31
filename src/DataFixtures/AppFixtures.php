<?php

namespace App\DataFixtures;

use App\Entity\Airline;
use App\Entity\User;
use App\Enum\Status;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setFirstName('Bhima')
            ->setLastName('Thakur')
            ->setEmail('bhimathakur@gmail.com')
            ->setPassword('$2y$13$XG4gLUyysqFvt14dEiUu0OZh7bIhMzLHoacrRwEpzWuS6jEvMXq2.')
            ->setRoles(['ROLE_ADMIN'])
            ->setZipcode(12345)
            ->setStatus(Status::ACTIVE)
            ->setMobile(9876543210)
            ->setCreatedAt(new DateTime())

        ;

        $manager->persist($user);

        $manager->flush();
        $this->airlines($manager);
    }

    private function airlines($manager)
    {
        $airlines = [
            'United Airlines',
            'American Airlines',
            'JetBlue',
            'Southwest Air',
            'Spirit Airlines',
            'Frontier Airlines',
            'Air India',
            'Indigo',
            'SpiceJet',
            'GoAir',
            'Vistara'
        ];
        foreach ($airlines as $airline) {
            $airlineEntity = new Airline();
            $airlineEntity
                ->setName($airline)
                ->setImage('image.png')
                ->setPrice(rand(111, 999))
                ->setStatus(Status::ACTIVE)
                ->setDate(new DateTime())
            ;
        $manager->persist($airlineEntity);
        $manager->flush();
        }
    }
}
