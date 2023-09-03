<?php

namespace App\Tests\Controller;


use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EssControllerTest extends WebTestCase
{
    public function testVisitingWhileLoggedIn(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $usersRepository = $entityManager->getRepository(Users::class);
        $testUsers = $usersRepository->findOneBy(['email' => 'fatimazen24@gmail.fr']);
        $client->loginUser($testUsers);
        $crawler = $client->request('GET', '/ess');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1');
        $this->assertSelectorTextContains('h1', 'Mes ess');
    }
    public function testAdd():void
    {
        $client = static::createClient();
        $container = static::getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $usersRepository = $entityManager->getRepository(Users::class);
        $testUsers = $usersRepository->findOneBy(['email' => 'fatimazen24@gmail.fr']);

        $client->loginUser($testUsers);
        $crawler = $client->request('GET', '/ajoutEss');

        $form = $crawler->selectButton('Envoyer')->form();

            $form['ess_form[nameStructure]'] ='Valeur 1';
            $form['ess_form[sectorActivity]'] = 'Agriculture, sylviculture epêche';
            $form['ess_form[sectorActivity ]'] = 'Industrie extrctives';
            $form['ess_form[activity]'] = 'Valeur 3';
            $form['ess_form[description]'] = 'Valeur 4';
            $form['ess_form[siretNumber]'] = 'Valeur 5';
            $form['ess_form[email]'] = 'Valeur 6';
            $form['ess_form[label]'] = 'Valeur 7';
            $form['ess_form[legalStatus]'] = 'Valeur 8';
            $form['ess_form[imageFile]'] = 'Valeur 9';
            $form['ess_form[city]'] = 'Valeur 10';
            $form['ess_form[zipCode]'] = 'Valeur 11';
            $form['ess_form[adress]'] = 'Valeur 12';
            $form['ess_form[phoneNumber]'] = 'Valeur 13';
            $form['ess_form[socialNetworks]'] = 'Valeur 14';
            $form['ess_form[webSite]'] = 'Valeur 15';
            $form['ess_form[lastName]'] = 'Valeur 16';
            $form['ess_form[firstName]'] = 'Valeur 17';
            $form['ess_form[openingHoursMonday]'] = 'Valeur 18';
            $form['ess_form[save]'] = 'Valeur 19';
            // $form['ess_form[]'] = 'Valeur 20';
            // $form['ess_form[]'] = 'Valeur 21';
            // $form['ess_form[]'] = 'Valeur 22';
            // $form['ess_form[]'] = 'Valeur 23';
            // $form['ess_form[]'] = 'Valeur 24';
            // $form['ess_form[]'] = 'Valeur 25';
            // $form['ess_form[]'] = 'Valeur 26';









        
        
    }
}
