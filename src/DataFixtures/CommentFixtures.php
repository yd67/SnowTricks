<?php

namespace App\DataFixtures;

use Faker ;
use App\Entity\User;
use App\Entity\Comments;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');


        for ($i=0; $i < 30 ; $i++) { 
            $user = $this->getReference('user'.$faker->numberBetween(1,9));
            $trik = $this->getReference('trik'.$faker->numberBetween(1,12));

            $comment = new Comments ;
            $comment->setContent($faker->realText(100))
            ->setCreator($user) 
            ->setTriks($trik)
            ;

            $manager->persist($comment);
        }
        $manager->flush();
        
    }

    public function getDependencies()
    {
        return [
            TrikFixtures::class,
        ];
    }
}
