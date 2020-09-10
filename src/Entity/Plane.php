<?php

namespace App\Entity;

use App\Repository\PlaneRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Plane
 *
 * @ORM\Table(name="planes")
 * @ORM\Entity(repositoryClass=PlaneRepository::class)
 */
class Plane
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
     * @var string
     *
     * @JMS\Groups(groups={"default"})
     *
     * @ORM\Column(type="string", length=100, nullable=true, unique=true)
     */
    private $tailNumber;

    /**
     * @var PlaneModel
     *
     * @JMS\Groups(groups={"default"})
     * @ORM\ManyToOne(targetEntity=PlaneModel::class)
     */
    private $planeModel;

    /**
     * @var PlaneStates
     *
     * @JMS\Groups(groups={"default"})
     * @ORM\ManyToOne(targetEntity=PlaneStates::class)
     */
    private $state;

    /**
     * @var Hangar|null
     * @JMS\Groups(groups={"default"})
     * @ORM\ManyToOne(targetEntity=Hangar::class, inversedBy="planes")
     */
    private $hangar;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTailNumber(): ?string
    {
        return $this->tailNumber;
    }

    /**
     * @param string $tailNumber
     */
    public function setTailNumber(string $tailNumber): void
    {
        $this->tailNumber = $tailNumber;
    }

    /**
     * @return PlaneModel|null
     */
    public function getPlaneModel(): ?PlaneModel
    {
        return $this->planeModel;
    }

    /**
     * @param PlaneModel $planeModel
     */
    public function setPlaneModel(PlaneModel $planeModel): void
    {
        $this->planeModel = $planeModel;
    }

    /**
     * @return PlaneStates|null
     */
    public function getState(): ?PlaneStates
    {
        return $this->state;
    }

    /**
     * @param PlaneStates|null $state
     */
    public function setState(?PlaneStates $state): void
    {
        $this->state = $state;
    }

    /**
     * @return Hangar|null
     */
    public function getHangar(): ?Hangar
    {
        return $this->hangar;
    }

    /**
     * @param Hangar|null $hangar
     */
    public function setHangar(?Hangar $hangar): void
    {
        $this->hangar = $hangar;
    }

    /**
     * @param Hangar $hangar
     *
     * @return bool
     */
    public function containHangar(Hangar $hangar): bool
    {
        return $this->hangar->getId() === $hangar->getId();
    }

    /**
     * @return bool
     */
    public function hasHangar(): bool
    {
        return isset($this->hangar);
    }

    /**
     * @param Hangar $hangar
     *
     * @return bool
     */
    public function isInHangar(Hangar $hangar): bool
    {
        return $this->hasHangar() && $this->containHangar($hangar);
    }
}
