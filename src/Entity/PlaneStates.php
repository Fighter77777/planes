<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Class PlaneStates
 *
 * @ORM\Table(name="plane_states")
 * @ORM\Entity()
 */
class PlaneStates
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
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $name;

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
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
