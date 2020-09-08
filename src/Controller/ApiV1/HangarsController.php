<?php

namespace App\Controller\ApiV1;

use App\Entity\Hangar;
use App\Repository\HangarRepositoryInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HangarsController
 *
 * @Route("/hangars")
 */
class HangarsController
{
    /**
     * @var HangarRepositoryInterface
     */
    private $hangarRepository;

    /**
     * @param HangarRepositoryInterface $hangarRepository
     */
    public function __construct(HangarRepositoryInterface $hangarRepository)
    {
        $this->hangarRepository = $hangarRepository;
    }

    /**
     * @Route("", methods={"GET"}, name="Get hangars list")
     * @SWG\Tag(name="Hangars")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of hangars with planers and their characteristics",
     *     @SWG\Items(ref=@Model(type=Hangar::class))
     * )
     *
     * @return Hangar[]|null
     * @throws \Exception
     */
    public function getList()
    {
        $hangars = $this->hangarRepository->getHangarsWithPlanes();

        return $hangars;
    }

    /**
     * @Route("/{hangarId}", methods={"GET"}, requirements={"hangarId": "^[1-9]\d*$"}, name="Get a hangar")
     * @SWG\Tag(name="Hangars")
     * @SWG\Response(
     *     response=200,
     *     description="Returns a hangar with planers and their characteristics",
     *     @SWG\Items(ref=@Model(type=Hangar::class))
     * )
     *
     * @param int $hangarId
     * @return Hangar
     * @throws \Exception
     */
    public function getById(int $hangarId = null)
    {
        $hangar = $this->hangarRepository->getHangarWithPlanesById($hangarId);

        if (null === $hangar) {
            throw new NotFoundHttpException('Hangar not found');
        }

        return $hangar;
    }
}
