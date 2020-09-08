<?php

namespace App\Utils;

use App\Entity\Hangar;
use App\Entity\Plane;

/**
 * Interface ChangeHangarServiceInterface
 */
interface ChangeHangarServiceInterface
{
    /**
     * @param Hangar $hangar
     * @param Plane  $plane
     */
    public function extractPlaneFromHangar(Hangar $hangar, Plane $plane): void;

    /**
     * @param Hangar $hangar
     * @param Plane  $plane
     */
    public function insertPlaneToHangar(Hangar $hangar, Plane $plane): void;
}
