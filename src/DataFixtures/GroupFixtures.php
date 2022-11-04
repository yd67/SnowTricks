<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $groupName = [
        'Grabs',
        'Rotation',
        'Flips',
        'Slides',
       ];

       foreach ($groupName as $key => $value) {
        $group = new Group ;
        $group->setName($value);

        $manager->persist($group);

        $this->addReference('group'.$key, $group);
       }

        $manager->flush();
    }
}
