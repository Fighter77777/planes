<?php

namespace App\DataFixtures;

use App\Entity\Surface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SurfaceFixtures extends Fixture
{
    public const REFERENCE = 'test-surface';

    public function load(ObjectManager $manager)
    {
        $surface = new Surface();
        $surface->setName(self::REFERENCE);

        $manager->persist($surface);
        $manager->flush();

        // other fixtures can get this object using the SurfaceFixtures::SURFACE_REFERENCE constant
        $this->addReference(self::REFERENCE, $surface);
    }
}
