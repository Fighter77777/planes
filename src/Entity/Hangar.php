<?php

namespace App\Entity;

use App\Repository\HangarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Hangar
 *
 * @ORM\Table(name="hangars")
 * @ORM\Entity(repositoryClass=HangarRepository::class)
 */
class Hangar
{
    /**
     * @var int
     *
     * @JMS\Groups(groups={"default"})
     *
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var Collection|Plane[]
     * @JMS\Groups(groups={"withPlaners"})
     *
     * @ORM\OneToMany(targetEntity=Plane::class, mappedBy="hangar")
     */
    private $planes;

    /**
     * Hangar constructor.
     */
    public function __construct()
    {
        $this->planes = new ArrayCollection();
    }

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getPlanes(): Collection
    {
        return $this->planes;
    }

    /**
     * @param Plane $plane
     */
    public function addPlane(Plane $plane): void
    {
        if (!$this->planes->contains($plane)) {
            $this->planes[] = $plane;
            $plane->setHangar($this);
        }
    }

    /**
     * @param Plane $plane
     */
    public function removePlane(Plane $plane): void
    {
        if ($this->planes->contains($plane)) {
            $this->planes->removeElement($plane);
            if ($plane->getHangar() === $this) {
                $plane->setHangar(null);
            }
        }
    }
}

