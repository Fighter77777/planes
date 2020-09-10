<?php

namespace App\DataFixtures;

use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlaneFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE = 'test-plane-1';
    public const NOBODYS_PLANE_NAME = 'reserve-10';

    public function load(ObjectManager $manager)
    {
        $plane1 = new Plane();
        $plane1->setTailNumber(self::REFERENCE);
        $plane1->setPlaneModel($this->getReference(PlaneModelFixtures::REFERENCE));
        $plane1->setState($this->getReference(PlaneStatesFixtures::REFERENCE));

        $manager->persist($plane1);

        $plane2 = new Plane();
        $plane2->setTailNumber(self::NOBODYS_PLANE_NAME);
        $plane2->setPlaneModel($this->getReference(PlaneModelFixtures::REFERENCE));
        $plane2->setState($this->getReference(PlaneStatesFixtures::REFERENCE));

        $manager->persist($plane2);

        $manager->flush();

        $this->addReference(self::REFERENCE, $plane1);
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            PlaneModelFixtures::class,
            PlaneStatesFixtures::class,
        ];
    }
}
