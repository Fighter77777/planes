<?php

namespace App\DataFixtures;

use App\Entity\PlaneModel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlaneModelFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE = 'test-plane-model';

    public function load(ObjectManager $manager)
    {
        $planeModel = new PlaneModel();
        $planeModel->setName(self::REFERENCE);
        $planeModel->addPlaneModelWorkingHour($this->getReference(PlaneModelWorkingHoursFixtures::REFERENCE));
        $planeModel->addSurface($this->getReference(SurfaceFixtures::REFERENCE));
        $planeModel->addWeather($this->getReference(WeatherFixtures::REFERENCE));

        $manager->persist($planeModel);
        $manager->flush();

        $this->addReference(self::REFERENCE, $planeModel);
    }
    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            PlaneModelWorkingHoursFixtures::class,
            SurfaceFixtures::class,
            WeatherFixtures::class,
        ];
    }
}
