<?php

namespace Tests\AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use AppBundle\Service\ClubService;
use AppBundle\Entity\Club;
use PHPUnit\Framework\TestCase;

class ClubServiceTest extends TestCase
{
    /**
     * Test List club
     */
    public function testList()
    {
        $clubs = [
            [
                "id_club"=>"1", "name"=>"F.C. Barcelona", "image"=>"", "budget"=>"5000.00"
            ]
        ];

        $clubRepository = $this->createMock(ObjectRepository::class);
        $clubRepository->expects($this->any())
            ->method('findAll')
            ->willReturn($clubs);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($clubRepository);

        $clubService = new ClubService($entityManager);
        $this->assertEquals($clubs, $clubService->list());
    }

    /**
     * Test Edit club
     */
    public function testEdit()
    {
        $club = new Club();
        $club->setName("Test Name");
        $club->setImage("Test Image");
        $club->setBudget("Test Budget");

        $clubRepository = $this->createMock(ObjectRepository::class);
        $clubRepository->expects($this->any())
            ->method('find')
            ->willReturn($club);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($clubRepository);

        $clubService = new ClubService($entityManager);
        $this->assertEquals(true, $clubService->edit(100, $club));
    }

    /**
     * Test Create club
     */
    public function testCreate(){
        $club = new Club();
        $club->setName("Test Name");
        $club->setImage("Test Image");
        $club->setBudget("Test Budget");

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $clubService = new ClubService($entityManager);
        $this->assertEquals(true, $clubService->create($club));
    }

    /**
     * Test Check data minimal for club entity
     */
    public function testCheckMinimalRequireFields(){
        $club = new Club();
        $club->setName("Test Name");
        $club->setImage("Test Image");
        $club->setBudget("Test Budget");

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $clubService = new ClubService($entityManager);
        $this->assertEquals(true, $clubService->checkMinimalRequireFields($club));
    }
}