<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Class PlaneModel
 *
 * @ORM\Table(name="plane_models")
 * @ORM\Entity()
 */
class PlaneModel
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
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @var Collection|PlaneModelWorkingHours[]
     *
     * @JMS\Groups(groups={"default"})
     * @ORM\OneToMany(targetEntity=PlaneModelWorkingHours::class, mappedBy="planeModel")
     */
    private $planeModelWorkingHours;

    /**
     * @var Collection|Surface[]
     *
     * @JMS\Groups(groups={"default"})
     * @ORM\ManyToMany(targetEntity=Surface::class)
     * @ORM\JoinTable(name="plane_models_surfaces")
     */
    private $surfaces;

    /**
     * @var Collection|Weather[]
     *
     * @ORM\ManyToMany(targetEntity=Weather::class)
     * @ORM\JoinTable(name="plane_models_weathers")
     */
    private $weathers;

    /**
     * PlaneModel constructor.
     */
    public function __construct()
    {
        $this->planeModelWorkingHours = new ArrayCollection();
        $this->surfaces = new ArrayCollection();
        $this->weathers = new ArrayCollection();
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
     * @return Collection|PlaneModelWorkingHours[]
     */
    public function getPlaneModelWorkingHours(): Collection
    {
        return $this->planeModelWorkingHours;
    }

    /**
     * @return Collection|Surface[]
     */
    public function getSurfaces(): Collection
    {
        return $this->surfaces;
    }

    /**
     * @return Collection|Weather[]
     */
    public function getWeathers(): Collection
    {
        return $this->weathers;
    }
}
