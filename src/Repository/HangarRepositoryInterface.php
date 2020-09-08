<?php

namespace App\Repository;

use App\Entity\Hangar;

interface HangarRepositoryInterface
{
    function getHangarsWithPlanes(): ?array;
    function getHangarWithPlanesById(int $hangarId): ?Hangar;
}
