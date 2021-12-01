<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfessionalType
 *
 * @ORM\Table(name="professional_type")
 * @ORM\Entity
 */
class ProfessionalType
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_professional_type", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProfessionalType;



    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ProfessionalType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get idProfessionalType.
     *
     * @return int
     */
    public function getIdProfessionalType()
    {
        return $this->idProfessionalType;
    }
}
