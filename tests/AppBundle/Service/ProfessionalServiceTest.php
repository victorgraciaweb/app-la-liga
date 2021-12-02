<?php

namespace Tests\AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use AppBundle\Service\ProfessionalService;
use AppBundle\Entity\Professional;
use PHPUnit\Framework\TestCase;

class ProfessionalServiceTest extends TestCase
{
    /**
     * Test Check junior age
     */
    public function testCheckAgeJuniors()
    {
        $professional = new Professional();
        $professional->setName("Test name");
        $professional->setSurname("Test Image");
        $professional->setAlias("Test Alias");
        $professional->setDateBirth(new \DateTime("2003-10-10"));

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $professionalService = new ProfessionalService($entityManager);
        $this->assertEquals(true, $professionalService->checkAgeJuniors($professional));
    }

    /**
     * Test Calculate age from date
     */
    public function testAgeCalculate(){
        $entityManager = $this->createMock(EntityManagerInterface::class);
        
        $professionalService = new ProfessionalService($entityManager);
        $this->assertEquals(23, $professionalService->ageCalculate("1998-12-01"));
    }

    /**
     * Test Check data minimal for Professional entity
     */
    public function testCheckMinimalRequireFields(){
        $professional = new Professional();
        $professional->setName("Test name");
        $professional->setSurname("Test Image");
        $professional->setAlias("Test Alias");
        $professional->setDateBirth(new \DateTime("2020-10-10"));

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $professionalService = new ProfessionalService($entityManager);
        $this->assertEquals(true, $professionalService->checkMinimalRequireFields($professional));
    }
}