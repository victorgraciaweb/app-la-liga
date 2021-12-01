<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Service\Helpers;
use AppBundle\Service\ClubService;
use AppBundle\Entity\Club;

class ClubController extends FOSRestController
{
    private $clubService;

    /**
     * @param ClubService $clubService
     */
    
    /**
     * @param Helpers $helpers
     */

    public function __construct(ClubService $clubService, Helpers $helpers)
    {
        $this->clubService = $clubService;
        $this->helpers = $helpers;
    }

    /**
     * @Rest\Get("/list")
     */
    public function listAction()
    {
        $response = $this->clubService->list();

        return $response;
    }

    /**
     * @Rest\Post("/list-players")
     */
    public function listPlayersAction(Request $request)
    {
        $params = $this->helpers->decodeParams($request);

        $idClub = (isset($params->idClub)) ? $params->idClub : null;

        $response = $this->clubService->listPlayers($idClub);

        return $response;
    }

    /**
     * @Rest\Put("/edit")
     */
    public function editAction(Request $request)
    {
        $params = $this->helpers->decodeParams($request);

        $idClub = (isset($params->idClub)) ? $params->idClub : null;
        $name = (isset($params->name)) ? $params->name : null;
        $image = (isset($params->image)) ? $params->image : null;
        $budget = (isset($params->budget)) ? $params->budget : null;

        //Update club
        $club = new club();
        $club->setName($name);
        $club->setImage($image);
        $club->setBudget($budget);

        if($this->clubService->checkMinimalRequireFields($club)){
    
            if($this->clubService->edit($idClub, $club)){
                $response = array(
                    "code" => 200,
                    "message" => "Club updated"
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
     * @Rest\Post("/create")
     */
    public function createAction(Request $request)
    {
        $params = $this->helpers->decodeParams($request);

        $name = (isset($params->name)) ? $params->name : null;
        $image = (isset($params->image)) ? $params->image : null;
        $budget = (isset($params->budget)) ? $params->budget : null;

        //Create new club
        $club = new club();
        $club->setName($name);
        $club->setImage($image);
        $club->setBudget($budget);

        if($this->clubService->checkMinimalRequireFields($club)){
    
            if($this->clubService->create($club)){
                $response = array(
                    "code" => 200,
                    "message" => "Club created: ".$club->getIdClub()
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