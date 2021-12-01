<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Repository\ClubRepository;
use AppBundle\Entity\Club;

class ClubService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ClubRepository
     */
    private $clubRepository;
    
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->clubRepository = $this->entityManager->getRepository(Club::class);
    }

    /**
     * List all clubs 
     * @param void
     * @return array
     */
    public function list()
    {
        try {
            $clubs = $this->clubRepository->findAll();

            return $clubs;

        } catch (Exception $e) {
            $return = array(
                "code" => 400,
                "message" => "Error, getting data"
            );
        }
    }

    /**
     * List all players by club
     * @param int $idClub
     * @return array
     */
    public function listPlayers($idClub)
    {
        try {
            $clubs = $this->clubRepository->findAllPlayersByClub($idClub);

            return $clubs;

        } catch (Exception $e) {
            $return = array(
                "code" => 400,
                "message" => "Error, getting data"
            );
        }
    }

    /**
     * Edit club
     * @param int $idClub
     * @param Club $updatedClub
     * @return bool
     */
    public function edit($idClub, $updatedClub)
    {
        try {
            //Get club
            $club = $this->clubRepository->find($idClub);
            
            $club->setName($updatedClub->getName());
            $club->setImage($updatedClub->getImage());
            $club->setBudget($updatedClub->getBudget());

            $this->entityManager->persist($club);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Create new club
     * @param Club $club
     * @return bool
     */
    public function create($club)
    {
        try {
            $this->entityManager->persist($club);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Check data minimal for club entity
     * @param Club $club
     * @return bool
     */
    public function checkMinimalRequireFields($club){
        if(!empty($club->getName()) AND !empty($club->getImage()) AND !empty($club->getBudget())){
            return true;
        }else{
            return false;
        }
    }
}