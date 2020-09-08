<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Swagger\Annotations as SWG;

/**
 * Class PlaneModelWorkingHours
 *
 * @ORM\Table(name="plane_model_working_hours")
 * @ORM\Entity()
 */
class PlaneModelWorkingHours
{
    /**
     * @var int
     *
     * @JMS\Groups(groups={"default"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *
     * @JMS\Groups(groups={"default"})
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var \DateTimeImmutable
     *
     * @JMS\Groups(groups={"default"})
     * @JMS\Type("string")     *
     * @JMS\AccessType("public_method")
     * @SWG\Property(description="Time in such format 'HH:MM'. An example: 11:00")
     *
     * @ORM\Column(type="time_immutable")
     */
    private $start;

    /**
     * @var \DateTimeImmutable
     *
     * @JMS\Groups(groups={"default"})
     * @JMS\Type("string")
     * @JMS\AccessType("public_method")
     * @SWG\Property(description="Time in such format 'HH:MM'. An example: 11:00")
     *
     * @ORM\Column(type="time_immutable")
     */
    private $end;

    /**
     * @var PlaneModel
     *
     * @ORM\ManyToOne(targetEntity=PlaneModel::class, inversedBy="planeModelWorkingHours")
     */
    private $planeModel;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start->format('H:i');
    }

    /**
     * @param string $startTime
     */
    public function setStart($startTime): void
    {
        $this->start = \DateTimeImmutable("1970-01-01T{$startTime}:00");
    }

    /**
     * @return string
     */
    public function getEnd(): string
    {
        return $this->end->format('H:i');
    }

    /**
     * @param string $endTime
     */
    public function setEnd($endTime): void
    {
        $this->start = \DateTimeImmutable("1970-01-01T{$endTime}:00");
    }

    /**
     * @return PlaneModel|null
     */
    public function getPlaneModel(): ?PlaneModel
    {
        return $this->planeModel;
    }
}
