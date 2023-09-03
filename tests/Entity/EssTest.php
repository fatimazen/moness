<?php

namespace App\Tests\Entity;

use App\Entity\Ess;
use PHPUnit\Framework\TestCase;

class EssTest extends TestCase
{
    public function testSomething(): void
    {
        $ess = new Ess();

        $email= "fati@outlook.fr";
        $ess-> setEmail($email);
        $this->assertEquals($email, $ess->getEmail());

        $nameStructure= "nom de la structure";
        $ess->setNameStructure($nameStructure);
        $this->assertEquals($nameStructure, $ess->getNameStructure());

        $lastName= "Nom";
        $ess->setLastName($lastName);
        $this->assertEquals($lastName, $ess->getLastName());

        $firstName = "prénom";
        $ess->setFirstName($firstName);
        $this->assertEquals($firstName, $ess->getFirstName());

        $adress ="adresse";
        $ess->setAdress($adress);
        $this->assertEquals($adress, $ess->getAdress());

        $city = "ville";
        $ess->setCity($city);
        $this->assertEquals($city, $ess->getCity());

        $zipCode = "code postal";
        $ess->setZipCode($zipCode);
        $this->assertEquals($zipCode, $ess->getZipCode());

        $sectorActivity= ['secteur activité'];
        $ess->setSectorActivity($sectorActivity);
        $this->assertEquals($sectorActivity, $ess->getSectorActivity());

        $legalStatus = ['statut juridique'];
        $ess ->setLegalStatus($legalStatus);
        $this->assertEquals($legalStatus,$ess->getLegalStatus());

        $description = "description";
        $ess->setDescription($description);
        $this->assertEquals($description, $ess->getDescription());

        $phoneNumber ="numero de téléphone";
        $ess->setPhoneNumber($phoneNumber);
        $this->assertEquals($phoneNumber, $ess->getPhoneNumber());

        
        
        $this->assertTrue(true);
    }
}
