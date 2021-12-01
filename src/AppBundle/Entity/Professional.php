<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professional
 *
 * @ORM\Table(name="professional", indexes={@ORM\Index(name="fk_professional_professional_type1_idx", columns={"id_professional_type"}), @ORM\Index(name="fk_professional_position1_idx", columns={"id_position"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfessionalRepository")
 */
class Professional
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=true)
     */
    private $alias = 'NULL';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_birth", type="date", nullable=false)
     */
    private $dateBirth;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_professional", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProfessional;

    /**
     * @var \AppBundle\Entity\Position
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Position")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_position", referencedColumnName="id_position")
     * })
     */
    private $idPosition;

    /**
     * @var \AppBundle\Entity\ProfessionalType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProfessionalType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_professional_type", referencedColumnName="id_professional_type")
     * })
     */
    private $idProfessionalType;



    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Professional
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
     * Set surname.
     *
     * @param string $surname
     *
     * @return Professional
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname.
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set alias.
     *
     * @param string|null $alias
     *
     * @return Professional
     */
    public function setAlias($alias = null)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias.
     *
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set dateBirth.
     *
     * @param \DateTime $dateBirth
     *
     * @return Professional
     */
    public function setDateBirth($dateBirth)
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    /**
     * Get dateBirth.
     *
     * @return \DateTime
     */
    public function getDateBirth()
    {
        return $this->dateBirth;
    }

    /**
     * Get idProfessional.
     *
     * @return int
     */
    public function getIdProfessional()
    {
        return $this->idProfessional;
    }

    /**
     * Set idPosition.
     *
     * @param \AppBundle\Entity\Position|null $idPosition
     *
     * @return Professional
     */
    public function setIdPosition(\AppBundle\Entity\Position $idPosition = null)
    {
        $this->idPosition = $idPosition;

        return $this;
    }

    /**
     * Get idPosition.
     *
     * @return \AppBundle\Entity\Position|null
     */
    public function getIdPosition()
    {
        return $this->idPosition;
    }

    /**
     * Set idProfessionalType.
     *
     * @param \AppBundle\Entity\ProfessionalType|null $idProfessionalType
     *
     * @return Professional
     */
    public function setIdProfessionalType(\AppBundle\Entity\ProfessionalType $idProfessionalType = null)
    {
        $this->idProfessionalType = $idProfessionalType;

        return $this;
    }

    /**
     * Get idProfessionalType.
     *
     * @return \AppBundle\Entity\ProfessionalType|null
     */
    public function getIdProfessionalType()
    {
        return $this->idProfessionalType;
    }
}
