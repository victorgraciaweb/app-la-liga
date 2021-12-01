<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Service\Helpers;
use AppBundle\Service\ProfessionalService;
use AppBundle\Entity\Professional;

class ProfessionalController extends FOSRestController
{
    private $professionalService;

    /**
     * @param ProfessionalService $professionalService
     */

    /**
    * @param Helpers $helpers
    */

    public function __construct(ProfessionalService $professionalService, Helpers $helpers)
    {
        $this->professionalService = $professionalService;
        $this->helpers = $helpers;
    }

    /**
     * @Rest\Post("/create")
     */
    public function createAction(Request $request)
    {
        $params = $this->helpers->decodeParams($request);

        $idProfessionalType = (isset($params->idProfessionalType)) ? $params->idProfessionalType : null;
        $idPosition = (isset($params->idPosition)) ? $params->idPosition : null;
        $name = (isset($params->name)) ? $params->name : null;
        $surname = (isset($params->surname)) ? $params->surname : null;
        $alias = (isset($params->alias)) ? $params->alias : null;
        $dateBirth = (isset($params->dateBirth)) ? $params->dateBirth : null;

        //Create new Professional
        $professional = new Professional();
        $professional->setName($name);
        $professional->setSurname($surname);
        $professional->setAlias($alias);
        $professional->setDateBirth(new \DateTime($dateBirth));

        if($this->professionalService->checkMinimalRequireFields($professional)){
    
            //Check professional type creation
            switch($idProfessionalType) {
                case 1:

                    if($this->professionalService->createCoach($professional)){
                        $response = array(
                            "code" => 200,
                            "message" => "Coach created"
                        );
                    }else{
                        $response = array(
                            "code" => 400,
                            "message" => "Error, persisting data"
                        );
                    }
                    
                    break;

                case 2:

                    if($this->professionalService->createPlayer($idPosition, $professional)){
                        $response = array(
                            "code" => 200,
                            "message" => "Player created"
                        );
                    }else{
                        $response = array(
                            "code" => 400,
                            "message" => "Error, persisting data"
                        );
                    }

                    break;

                case 3:

                    if($this->professionalService->checkAgeJuniors($professional)){
                        
                        if($this->professionalService->createJunior($idPosition, $professional)){
                            $response = array(
                                "code" => 200,
                                "message" => "Junior created"
                            );
                        }else{
                            $response = array(
                                "code" => 400,
                                "message" => "Error, persisting data"
                            );
                        }

                    }else{
                        $response = array(
                            "code" => 400,
                            "message" => "23 years is the maximum age for Juniors"
                        );
                    }

                    break;

                default:

                    $response = array(
                        "code" => 400,
                        "message" => "You must select a Professional type"
                    );
            }
            
        }else{
            $response = array(
                "code" => 400,
                "message" => "You must send more data"
            );
        }

        return $response;
    }

    /**
     * @Rest\Put("/edit-player")
     */
    public function editPlayerAction(Request $request)
    {
        $params = $this->helpers->decodeParams($request);

        $idProfessional = (isset($params->idProfessional)) ? $params->idProfessional : null;
        $idPosition = (isset($params->idPosition)) ? $params->idPosition : null;
        $name = (isset($params->name)) ? $params->name : null;
        $surname = (isset($params->surname)) ? $params->surname : null;
        $alias = (isset($params->alias)) ? $params->alias : null;
        $dateBirth = (isset($params->dateBirth)) ? $params->dateBirth : null;

        //Update player
        $professional = new Professional();
        $professional->setName($name);
        $professional->setSurname($surname);
        $professional->setAlias($alias);
        $professional->setDateBirth(new \DateTime($dateBirth));

        if($this->professionalService->checkMinimalRequireFields($professional)){
    
            if($this->professionalService->editPlayer($idProfessional, $idPosition, $professional)){
                $response = array(
                    "code" => 200,
                    "message" => "Professional updated"
                );
            }else{
                $response = array(
                    "code" => 400,
                    "message" => "Error, persisting data"
                );
            }
            
        }else{
            $response = array(
                "code" => 400,
                "message" => "You must send more data"
            );
        }

        return $response;
    }
    
    /**
     * @Rest\Get("/list-players")
     */
    public function listPlayersAction()
    {
        $response = $this->professionalService->listPlayers();

        return $response;
    }

    /**
     * @Rest\Post("/add-club")
     */
    public function addClubAction(Request $request)
    {
        $params = $this->helpers->decodeParams($request);

        $idProfessionalType = (isset($params->idProfessionalType)) ? $params->idProfessionalType : null;
        $idProfessional = (isset($params->idProfessional)) ? $params->idProfessional : null;
        $idClub = (isset($params->idClub)) ? $params->idClub : null;
        $salary = (isset($params->salary)) ? $params->salary : null;

        //Check professional type
        switch($idProfessionalType) {
            case 1:

                //Check if exist coach in other club
                if($this->professionalService->checkCoachAvailableInClub($idClub)){
                    
                    if($this->professionalService->addClubCoach($idProfessional, $idClub, $salary)){
                        $response = array(
                            "code" => 200,
                            "message" => "Coach associated to club"
                        );
                    }else{
                        $response = array(
                            "code" => 400,
                            "message" => "Error, persisting data"
                        );
                    }

                }else{
                    $response = array(
                        "code" => 400,
                        "message" => "Club has coach, select other option"
                    );
                }

                break;

            case 2:

                //Check if exist player in any club associated
                if($this->professionalService->checkPlayerAssociatedClub($idProfessional)){

                    //Check players number by club
                    if($this->professionalService->checkPlayersNumberByClub($idClub)){
                        
                        //Check top budget by club 
                        if($this->professionalService->checkTopBudgetByClub($idClub, $salary)){
                            
                            if($this->professionalService->addClubPlayer($idProfessional, $idClub, $salary)){

                                //Notification by mail
                                if($this->helpers->sendNotificationByMail()){

                                    $response = array(
                                        "code" => 200,
                                        "message" => "Player associated to club"
                                    );

                                }else{
                                    $response = array(
                                        "code" => 400,
                                        "message" => "Error sending notification"
                                    );
                                }

                            }else{
                                $response = array(
                                    "code" => 400,
                                    "message" => "Error, persisting data"
                                );
                            }
                            
                        }else{
                            $response = array(
                                "code" => 400,
                                "message" => "Club needs more budget"
                            );
                        }

                    }else{
                        $response = array(
                            "code" => 400,
                            "message" => "Club has maximun players associated"
                        );
                    }

                }else{
                    $response = array(
                        "code" => 400,
                        "message" => "Player playing in other club"
                    );
                }

                break;

            case 3:

                if($this->professionalService->addClubJunior($idProfessional, $idClub)){
                    $response = array(
                        "code" => 200,
                        "message" => "Junior associated to club"
                    );
                }else{
                    $response = array(
                        "code" => 400,
                        "message" => "Error, persisting data"
                    );
                }

                break;

            default:

                $response = array(
                    "code" => 400,
                    "message" => "You must select a Professional type"
                );
        }

        return $response;
    }

    /**
     * @Rest\Delete("/delete-club")
     */
    public function deleteClubAction(Request $request)
    {
        $params = $this->helpers->decodeParams($request);

        $idProfessionalClub = (isset($params->idProfessionalClub)) ? $params->idProfessionalClub : null;

        if($idProfessionalClub){
    
            if($this->professionalService->deleteClub($idProfessionalClub)){
                $response = array(
                    "code" => 200,
                    "message" => "Professional deleted from Club"
                );
            }else{
                $response = array(
                    "code" => 400,
                    "message" => "Error, persisting data"
                );
            }
            
        }else{
            $response = array(
                "code" => 400,
                "message" => "You must send more data"
            );
        }

        return $response;
    }
}
