<?php

namespace App\DataFixtures;

use App\Entity\PlaneModelWorkingHours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlaneModelWorkingHoursFixtures extends Fixture
{
    public const REFERENCE = 'test-working-hours';

    public function load(ObjectManager $manager)
    {
        $workingHours = new PlaneModelWorkingHours();
        $workingHours->setName(self::REFERENCE);
        $workingHours->setStart('09:00');
        $workingHours->setEnd('20:30');

        $manager->persist($workingHours);
        $manager->flush();

        $this->addReference(self::REFERENCE, $workingHours);
    }
}
