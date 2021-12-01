<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProfessionalRepository extends EntityRepository
{
    public function findAllPlayers()
    {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $query = "SELECT
        professional.id_professional,
        position.name AS position,
        professional.name,
        professional.surname,
        professional.alias, 
        professional.date_birth 
        FROM professional
        INNER JOIN position ON position.id_position = professional.id_professional
        WHERE professional.id_professional_type = 2";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}