<?php

namespace App\Tests\Controller;

use App\DataFixtures\HangarFixtures;
use App\Entity\Hangar;
use App\Repository\HangarRepository;

/**
 * Class HangarsControllerTest
 */
class HangarsControllerTest extends FixtureTestCase
{
    /**
     * @var HangarRepository
     */
    private $hangarRepository;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();
        $this->hangarRepository = $kernel->getContainer()->get('doctrine')->getRepository(Hangar::class);
    }

    public function testSuccessfulGetList(): void
    {
        $this->getClientInstance()->request('GET', 'api/v1/hangars');

        $response = $this->getClientInstance()->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());

        $responseArray = json_decode($response->getContent(), true);

        $this->assertIsArray($responseArray);
        $this->assertNotEmpty($responseArray);

        $this->checkHangar($responseArray[0]);
    }

    public function testSuccessfulGetHangar(): void
    {
        /* @var Hangar $hangar */
        $hangar = $this->hangarRepository->findOneBy(['name' => HangarFixtures::HANGAR_NAME]);
        $this->assertInstanceOf(Hangar::class, $hangar);

        $this->getClientInstance()->request('GET', 'api/v1/hangars/'.$hangar->getId());

        $response = $this->getClientInstance()->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());

        $responseArray = json_decode($response->getContent(), true);

        $this->checkHangar($responseArray);
    }

    public function testGetNotExistHangar(): void
    {
        $this->getClientInstance()->request('GET', 'api/v1/hangars/99999999');

        $response = $this->getClientInstance()->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJson($response->getContent());
        //TODO check structure of response
    }

    /**
     * TODO change to JSON scheme validation https://json-schema.org/implementations.html
     *
     * @param array $hangar
     */
    private function checkHangar(array $hangar): void
    {
        $this->assertNotEmpty($hangar);

        $this->assertArrayHasKey('name', $hangar);
        $this->assertArrayHasKey('planes', $hangar);

        $this->assertIsArray($hangar['planes']);
        $this->assertNotEmpty($hangar['planes']);

        //TODO check all nodes
    }
}
