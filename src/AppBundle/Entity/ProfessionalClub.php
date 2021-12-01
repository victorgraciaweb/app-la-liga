<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfessionalClub
 *
 * @ORM\Table(name="professional_club", indexes={@ORM\Index(name="fk_professional_has_club_club1_idx", columns={"id_club"}), @ORM\Index(name="fk_professional_has_club_professional_idx", columns={"id_professional"})})
 * @ORM\Entity
 */
class ProfessionalClub
{
    /**
     * @var string
     *
     * @ORM\Column(name="salary", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $salary = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="id_professional_club", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProfessionalClub;

    /**
     * @var \AppBundle\Entity\Club
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Club")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_club", referencedColumnName="id_club")
     * })
     */
    private $idClub;

    /**
     * @var \AppBundle\Entity\Professional
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Professional")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_professional", referencedColumnName="id_professional")
     * })
     */
    private $idProfessional;



    /**
     * Set salary.
     *
     * @param string|null $salary
     *
     * @return ProfessionalClub
     */
    public function setSalary($salary = null)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary.
     *
     * @return string|null
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Get idProfessionalClub.
     *
     * @return int
     */
    public function getIdProfessionalClub()
    {
        return $this->idProfessionalClub;
    }

    /**
     * Set idClub.
     *
     * @param \AppBundle\Entity\Club|null $idClub
     *
     * @return ProfessionalClub
     */
    public function setIdClub(\AppBundle\Entity\Club $idClub = null)
    {
        $this->idClub = $idClub;

        return $this;
    }

    /**
     * Get idClub.
     *
     * @return \AppBundle\Entity\Club|null
     */
    public function getIdClub()
    {
        return $this->idClub;
    }

    /**
     * Set idProfessional.
     *
     * @param \AppBundle\Entity\Professional|null $idProfessional
     *
     * @return ProfessionalClub
     */
    public function setIdProfessional(\AppBundle\Entity\Professional $idProfessional = null)
    {
        $this->idProfessional = $idProfessional;

        return $this;
    }

    /**
     * Get idProfessional.
     *
     * @return \AppBundle\Entity\Professional|null
     */
    public function getIdProfessional()
    {
        return $this->idProfessional;
    }
}
