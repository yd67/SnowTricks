<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker ;

class UserFixtures extends Fixture
{
    private $passwordHasher ;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->passwordHasher = $userPasswordHasher ;
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < 10 ; $i++) { 
            $user = new User ;
            $user->setUsername($faker->userName())
            ->setEmail($faker->email())
            ->setPassword(
                $this->passwordHasher->hashPassword(
                        $user,
                        'test'
                    )
                )
            ->setAvatar('default.jpg')
            ->setIsVerified(true)
            ;

            $manager->persist($user);

            $this->addReference('user'.$i, $user);
         }

        $manager->flush();
    }
}
