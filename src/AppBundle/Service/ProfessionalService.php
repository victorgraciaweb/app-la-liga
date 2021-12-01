<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Repository\ProfessionalRepository;
use AppBundle\Repository\ProfessionalTypeRepository;
use AppBundle\Repository\PositionRepository;
use AppBundle\Repository\ProfessionalClubRepository;
use AppBundle\Entity\Professional;
use AppBundle\Entity\ProfessionalType;
use AppBundle\Entity\Position;
use AppBundle\Entity\ProfessionalClub;
use AppBundle\Entity\Club;

class ProfessionalService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProfessionalRepository
     */
    private $professionalRepository;

    /**
     * @var ProfessionalTypeRepository
     */
    private $professionalTypeRepository;

    /**
     * @var PositionRepository
     */
    private $positionRepository;

    /**
     * @var ProfessionalClubRepository
     */
    private $professionalClubRepository;

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
        $this->professionalRepository = $this->entityManager->getRepository(Professional::class);
        $this->professionalTypeRepository = $this->entityManager->getRepository(ProfessionalType::class);
        $this->positionRepository = $this->entityManager->getRepository(Position::class);
        $this->professionalClubRepository = $this->entityManager->getRepository(ProfessionalClub::class);
        $this->clubRepository = $this->entityManager->getRepository(Club::class);
    }

    /**
     * Create Coach
     * @param Professional $professional
     * @return bool
     */
    public function createCoach($professional)
    {
        try {
            //Get typeProfessional of coach entity
            $professionalType = $this->professionalTypeRepository->find(1);
            $professional->setIdProfessionalType($professionalType);

            $this->entityManager->persist($professional);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Create Player
     * @param id $idPosition
     * @param Professional $professional
     * @return bool
     */
    public function createPlayer($idPosition, $professional)
    {
        try {
            //Get typeProfessional of player entity
            $professionalType = $this->professionalTypeRepository->find(2);
            $professional->setIdProfessionalType($professionalType);

            //Get position of players entity
            $position = $this->positionRepository->find($idPosition);
            
            //Only for Players and Juniors
            $professional->setIdPosition($position);

            $this->entityManager->persist($professional);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Create Junior
     * @param id $idPosition
     * @param Professional $professional
     * @return bool
     */
    public function createJunior($idPosition, $professional)
    {
        try {
            //Get typeProfessional of Junior entity
            $professionalType = $this->professionalTypeRepository->find(3);
            $professional->setIdProfessionalType($professionalType);

            //Get position of players entity
            $position = $this->positionRepository->find($idPosition);
            
            //Only for Players and Juniors
            $professional->setIdPosition($position);

            $this->entityManager->persist($professional);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * List all players
     * @param void
     * @return array
     */
    public function listPlayers()
    {
        try {
            $professionals = $this->professionalRepository->findAllPlayers();

            return $professionals;

        } catch (Exception $e) {
            $return = array(
                "code" => 400,
                "message" => "Error, getting data"
            );
        }
    }

    /**
     * Associate Coach to club
     * @param int $idProfessional
     * @param int $idClub
     * @param float $salary
     * @return bool
     */
    public function addClubCoach($idProfessional, $idClub, $salary)
    {
        try {
            //Get Coach
            $professional = $this->professionalRepository->find($idProfessional);

            //Get club
            $club = $this->clubRepository->find($idClub);

            //Create new association Coach and Club
            $professionalClub = new ProfessionalClub();
            $professionalClub->setIdProfessional($professional);
            $professionalClub->setIdClub($club);
            $professionalClub->setSalary($salary);

            $this->entityManager->persist($professionalClub);
            $this->entityManager->flush();

            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Associate Player to club
     * @param int $idProfessional
     * @param int $idClub
     * @param float $salary
     * @return bool
     */
    public function addClubPlayer($idProfessional, $idClub, $salary)
    {
        try {
            //Get player
            $professional = $this->professionalRepository->find($idProfessional);

            //Get club
            $club = $this->clubRepository->find($idClub);

            //Create new association Player and Club
            $professionalClub = new ProfessionalClub();
            $professionalClub->setIdProfessional($professional);
            $professionalClub->setIdClub($club);
            $professionalClub->setSalary($salary);

            $this->entityManager->persist($professionalClub);
            $this->entityManager->flush();

            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Associate Junior to club
     * @param int $idProfessional
     * @param int $idClub
     * @return bool
     */
    public function addClubJunior($idProfessional, $idClub)
    {
        try {
            //Get Junior
            $professional = $this->professionalRepository->find($idProfessional);

            //Get club
            $club = $this->clubRepository->find($idClub);

            //Create new association Junior and Club
            $professionalClub = new ProfessionalClub();
            $professionalClub->setIdProfessional($professional);
            $professionalClub->setIdClub($club);
            $professionalClub->setSalary(null);

            $this->entityManager->persist($professionalClub);
            $this->entityManager->flush();

            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete player from club
     * @param int $idProfessionalClub
     * @return bool
     */
    public function deleteClub($idProfessionalClub)
    {
        try {
            $professionalClub = $this->professionalClubRepository->find($idProfessionalClub);

            if(!empty($professionalClub)){
                $this->entityManager->remove($professionalClub);
                $this->entityManager->flush();

                return true;
            }else{
                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Edit player
     * @param int $idProfessional
     * @param int $idPosition
     * @param Professionals $updatedProfessional
     * @return bool
     */
    public function editPlayer($idProfessional, $idPosition, $updatedProfessional)
    {
        try {
            //Get Player
            $professional = $this->professionalRepository->find($idProfessional);

            //Get position of player
            $position = $this->positionRepository->find($idPosition);

            //Update player
            $professional->setIdPosition($position);
            $professional->setName($updatedProfessional->getName());
            $professional->setSurname($updatedProfessional->getSurname());
            $professional->setAlias($updatedProfessional->getAlias());
            $professional->setDateBirth($updatedProfessional->getDateBirth());

            $this->entityManager->persist($professional);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Check if club has coach
     * @param int $idClub
     * @return bool
     */
    public function checkCoachAvailableInClub($idClub)
    {
        //Check if exist coach in club
        $checkCoach = $this->clubRepository->checkIfExistCoach($idClub);
    
        if(empty($checkCoach)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if player is associated to club
     * @param int $idProfessional
     * @return bool
     */
    public function checkPlayerAssociatedClub($idProfessional)
    {
        //Check if exist player in any club associated
        $checkPlayer = $this->professionalClubRepository->findOneBy([
            'idProfessional' => $idProfessional
        ]);

        if(!$checkPlayer){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check number of players by club
     * @param int $idClub
     * @return bool
     */
    public function checkPlayersNumberByClub($idClub)
    {
        //Check players number by club
        $checkPlayersNumber = $this->clubRepository->checkPlayersNumberByClub($idClub);

        if(count($checkPlayersNumber) < 5){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check club budget
     * @param int $idClub
     * @param float $salary
     * @return bool
     */
    public function checkTopBudgetByClub($idClub, $salary)
    {
        //Check top budget by club
        $checkTopBudget = $this->clubRepository->checkTopBudgetByClub($idClub); 
        $checkTopBudget = $checkTopBudget[0]['budget'];

        //Check total Player Salary by Club
        $totalPlayerSalary = $this->clubRepository->getTotalPlayerSalaryByClub($idClub); 
        $totalPlayerSalary = $totalPlayerSalary[0]['total_salary'];

        if($totalPlayerSalary + $salary <= $checkTopBudget){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check junior age
     * @param Professional $professional
     * @return bool
     */
    public function checkAgeJuniors($professional)
    {
        $date = $professional->getDateBirth();
        $result = $date->format('Y-m-d');
        $years = $this->ageCalculate($result);

        if($years <= 23){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Calculate age from date
     * @param string $fechanacimiento
     * @return string
     */
    public function ageCalculate($fechanacimiento){
        list($ano,$mes,$dia) = explode("-",$fechanacimiento);
        $ano_diferencia  = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
          $ano_diferencia--;
        return $ano_diferencia;
    }

    /**
     * Check data minimal for professional entity
     * @param Professional $professional
     * @return bool
     */
    public function checkMinimalRequireFields($professional){
        if(!empty($professional->getName()) AND !empty($professional->getSurname()) AND !empty($professional->getAlias()) AND !empty($professional->getDateBirth())){
            return true;
        }else{
            return false;
        }
    }
}