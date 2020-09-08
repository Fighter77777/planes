<?php

namespace App\Controller\ApiV1;

use App\Entity\Hangar;
use App\Entity\Plane;
use App\Utils\ChangeHangarServiceInterface;
use AppBundle\Exception\ChangeHangarException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlanersInHangarController
 *
 * @Route("/hangars")
 */
class PlanersInHangarController
{
    /**
     * @var ChangeHangarServiceInterface
     */
    private $changeHangarService;

    /**
     * @param ChangeHangarServiceInterface $changeHangarService
     */
    public function __construct(ChangeHangarServiceInterface $changeHangarService)
    {
        $this->changeHangarService = $changeHangarService;
    }

    /**
     * @Route(
     *     "/{hangar}/planes/{plane}",
     *     methods={"DELETE"},
     *     requirements={"hangar": "^[1-9]\d*$", "plane": "^[1-9]\d*$"},
     *     name="Take a plane from a hangar"
     * )
     * @SWG\Tag(name="Change a hangar for a plane")
     * @SWG\Response(
     *     response=200,
     *     description="Take a plane out of a hangar",
     *     @SWG\Items(ref=@Model(type=Plane::class))
     * )
     *
     * @param Hangar|null $hangar
     * @param Plane|null $plane
     * @return Plane
     */
    public function deletePlaneFromHangar(Hangar $hangar, Plane $plane): Plane
    {
        try {
            $this->changeHangarService->extractPlaneFromHangar($hangar, $plane);
        } catch (ChangeHangarException $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return $plane;
    }

    /**
     * @Route(
     *     "/{hangar}/planes",
     *     methods={"POST"},
     *     requirements={"hangar": "^[1-9]\d*$"},
     *     name="Take a plane to a hangar"
     * )
     * @SWG\Tag(name="Change a hangar for a plane")
     * @SWG\Parameter(
     *     name="Plane",
     *     in="body",
     *     description="Json with id of a plane that shoud add to hangar",
     *     type="json",
     *     required=true,
     *     @Model(type=Plane::class)
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Take a plane to a hangar",
     *     @SWG\Items(ref=@Model(type=Plane::class, groups={"default"}))
     * )
     * @Rest\View(serializerGroups={"default"})
     *
     * @ParamConverter(name="plane", class="App\Entity\Plane", converter="entity_in_body_converter")
     *
     * @param Hangar $hangar
     * @param Plane $plane
     * @return Plane
     */
    public function addPlaneToHangar(Hangar $hangar, Plane $plane): Plane
    {
        try {
            $this->changeHangarService->insertPlaneToHangar($hangar, $plane);
        } catch (ChangeHangarException $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return $plane;
    }
}
