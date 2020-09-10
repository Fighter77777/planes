<?php

namespace App\Tests\Controller;

use App\DataFixtures\HangarFixtures;
use App\DataFixtures\PlaneFixtures;
use App\Entity\Hangar;
use App\Entity\Plane;
use App\Repository\HangarRepository;
use App\Repository\PlaneRepository;

/**
 * Class HangarsControllerTest
 */
class PlanersInHangarControllerTest extends FixtureTestCase
{
    /**
     * @var HangarRepository
     */
    private $hangarRepository;

    /**
     * @var PlaneRepository
     */
    private $planeRepository;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();

        $doctrine = $kernel->getContainer()->get('doctrine');
        $this->hangarRepository = $doctrine->getRepository(Hangar::class);
        $this->planeRepository = $doctrine->getRepository(Plane::class);
    }

    public function testSuccessfulDeletePlaneFromHangar(): void
    {
        /* @var Hangar $hangar */
        $hangar = $this->hangarRepository->findOneBy(['name' => HangarFixtures::HANGAR_NAME]);

        $this->assertInstanceOf(Hangar::class, $hangar);
        $this->assertNotEmpty($hangar->getPlanes());
        $this->assertInstanceOf(Plane::class, $hangar->getPlanes()[0]);



        $this->getClientInstance()->request(
            'DELETE',
            sprintf('api/v1/hangars/%d/planes/%d', $hangar->getId(), $hangar->getPlanes()[0]->getId())
        );

        $response = $this->getClientInstance()->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());

        $responseArray = json_decode($response->getContent(), true);

        $this->assertIsArray($responseArray);
        $this->assertNotEmpty($responseArray);
    }

    public function testSuccessfulAddPlaneToHangar(): void
    {
        /* @var Hangar $hangar */
        $hangar = $this->hangarRepository->findOneBy(['name' => HangarFixtures::HANGAR_NAME]);
        $this->assertInstanceOf(Hangar::class, $hangar);

        /* @var Plane $plane */
        $plane = $this->planeRepository->findOneBy(['tailNumber' => PlaneFixtures::NOBODYS_PLANE_NAME]);
        $this->assertInstanceOf(Plane::class, $plane);

        $this->getClientInstance()->request(
            'POST',
            sprintf('api/v1/hangars/%d/planes', $hangar->getId()),
                [],
                [],
                [],
                json_encode(['id' => $plane->getId()])
        );

        $response = $this->getClientInstance()->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());

        $responseArray = json_decode($response->getContent(), true);

        $this->assertIsArray($responseArray);
        $this->assertNotEmpty($responseArray);
    }
}
