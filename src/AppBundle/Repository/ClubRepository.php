<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClubRepository extends EntityRepository
{
    public function findAll()
    {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $query = "SELECT * FROM club";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findAllPlayersByClub($idClub)
    {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $query = "SELECT
        professional.id_professional,
        position.name AS position,
        club.name AS club,
        professional_club.salary AS salary,
        professional.name,
        professional.surname,
        professional.alias, 
        professional.date_birth 
        FROM professional
        INNER JOIN position ON professional.id_professional = position.id_position
        INNER JOIN professional_club ON professional.id_professional = professional_club.id_professional
        INNER JOIN club ON club.id_club = professional_club.id_club
        WHERE professional.id_professional_type = 2
        AND club.id_club = '".$idClub."'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function checkIfExistCoach($idClub)
    {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $query = "SELECT * FROM professional 
        WHERE id_professional_type = 1 
        AND id_professional IN 
        (SELECT id_professional 
        FROM professional_club 
        WHERE id_club = '".$idClub."')";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function checkPlayersNumberByClub($idClub)
    {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $query = "SELECT * FROM professional 
        WHERE id_professional_type = 2
        AND id_professional IN 
        (SELECT id_professional 
        FROM professional_club 
        WHERE id_club = '".$idClub."')";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function checkTopBudgetByClub($idClub)
    {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $query = "SELECT budget FROM club WHERE id_club = '".$idClub."'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getTotalPlayerSalaryByClub($idClub)
    {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $query = "SELECT SUM(salary) AS total_salary FROM professional_club WHERE id_club = '".$idClub."'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}