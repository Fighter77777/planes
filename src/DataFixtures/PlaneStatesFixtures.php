<?php

namespace App\DataFixtures;

use App\Entity\PlaneStates;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlaneStatesFixtures extends Fixture
{
    public const REFERENCE = 'test-state';

    public function load(ObjectManager $manager)
    {
        $state = new PlaneStates();
        $state->setName(self::REFERENCE);

        $manager->persist($state);
        $manager->flush();

        $this->addReference(self::REFERENCE, $state);
    }
}
