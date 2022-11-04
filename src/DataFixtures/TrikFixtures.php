<?php

namespace App\DataFixtures ;

use App\Entity\Triks;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker ;

class TrikFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugger ;
    
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger ;
        
    }
    public function load(ObjectManager $manager): void
    {
        $triksName = [
            'Air to Fakie',
            'Grabs',
            'Half-pipe',
            'Lipslide',
            'Mc Twist',
            'Rodeoback & Rodeofront',
            'Quarter pipe',
            'frontside underflip 540',
            'Vitelli Turn',
            'Wildcat',
            'Twin tip',
            '810',
            '630',
        ];

        $faker = Faker\Factory::create('fr_FR');

        foreach ($triksName as $key => $value) {
            $triks = new Triks ;
            $slug = $this->slugger->slug($value);
            $group = $this->getReference('group'.$faker->numberBetween(0,3));
            $user = $this->getReference('user'.$faker->numberBetween(1,9));

            $triks->setName($value) ;
            $triks->setSlug($slug);
            $triks->setDescription($faker->realText());
            $triks->setGroupes($group);
            $triks->setCreator($user);

            $manager->persist($triks);

            $this->addReference('trik'.$key, $triks);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            GroupFixtures::class,
        ];
    }

}