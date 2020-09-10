<?php

namespace App\DataFixtures;

use App\Entity\Weather;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WeatherFixtures extends Fixture
{
    public const REFERENCE = 'test-weather';

    public function load(ObjectManager $manager)
    {
        $weather = new Weather();
        $weather->setName(self::REFERENCE);

        $manager->persist($weather);
        $manager->flush();

        $this->addReference(self::REFERENCE, $weather);
    }
}
