<?php

namespace App\DataFixtures;

use App\Entity\Hangar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class HangarFixtures
 */
class HangarFixtures extends Fixture implements DependentFixtureInterface
{
    public const HANGAR_NAME = 'test-hangar';
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $surface = new Hangar();
        $surface->setName(self::HANGAR_NAME);
        $surface->addPlane($this->getReference(PlaneFixtures::REFERENCE));

        $manager->persist($surface);

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [PlaneFixtures::class];
    }
}
