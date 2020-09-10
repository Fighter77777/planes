<?php

namespace App\Utils;

use App\Entity\Hangar;
use App\Entity\Plane;
use App\Repository\HangarSaveRepositoryInterface;
use App\Exception\ChangeHangarException;

/**
 * Class ChangeHangarService
 */
class ChangeHangarService implements ChangeHangarServiceInterface
{
    /**
     * @var HangarSaveRepositoryInterface
     */
    private $hangarRepository;

    /**
     * @param HangarSaveRepositoryInterface $hangarRepository
     */
    public function __construct(HangarSaveRepositoryInterface $hangarRepository)
    {
        $this->hangarRepository = $hangarRepository;
    }

    /**
     * @param Hangar $hangar
     * @param Plane  $plane
     */
    public function extractPlaneFromHangar(Hangar $hangar, Plane $plane): void
    {
        if (!$plane->isInHangar($hangar)) {
            throw new ChangeHangarException('This plane is not this hangar');
        }

        $hangar->removePlane($plane);
        $this->hangarRepository->save();
    }

    /**
     * @param Hangar $hangar
     * @param Plane  $plane
     */
    public function insertPlaneToHangar(Hangar $hangar, Plane $plane): void
    {

        if ($plane->isInHangar($hangar)) {
            throw new ChangeHangarException('This plane is already in this hangar');
        }

        if ($plane->hasHangar()) {
            throw new ChangeHangarException(
                'This plane is in another hangar. You should first take the plane out of its hangar.'
            );
        }

        $hangar->addPlane($plane);
        $this->hangarRepository->save();
    }
}
