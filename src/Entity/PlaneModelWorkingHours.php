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
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
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
        $this->start = $this->timeToDate($startTime);
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
        $this->end = $this->timeToDate($endTime);
    }

    /**
     * @return PlaneModel|null
     */
    public function getPlaneModel(): ?PlaneModel
    {
        return $this->planeModel;
    }

    /**
     * @param PlaneModel|null $planeModel
     *
     * @return PlaneModelWorkingHours
     */
    public function setPlaneModel(?PlaneModel $planeModel): self
    {
        $this->planeModel = $planeModel;

        return $this;
    }

    /**
     * @param $time
     *
     * @return \DateTimeImmutable
     */
    private function timeToDate($time): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat ('H:i', $time);
    }


}
