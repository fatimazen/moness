<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Activity;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\DataFixtures\AppFixtures;

class ActivityFixtures extends Fixture 
{
    private $counter = 1;

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    
    public function load(ObjectManager $manager): void
    {


        $parent = $this->createActivity('Restauration', null, $manager);

        $this->createActivity('Snack', $parent, $manager);
        $this->createActivity('Traiteur', $parent, $manager);
        $this->createActivity('Collectivité', $parent, $manager);

        $parent = $this->createActivity('Services', null, $manager);

        $this->createActivity('Ambulance', $parent, $manager);
        $this->createActivity('Blanchisserie et pressing', $parent, $manager);
        $this->createActivity('Coiffure', $parent, $manager);
        $this->createActivity('Composition florales', $parent, $manager);
        $this->createActivity('Contrôle technique', $parent, $manager);
        $this->createActivity('Déménagement', $parent, $manager);
        $this->createActivity('Entretient et réparation de machines de bureau et de matériel informatique', $parent, $manager);
        $this->createActivity('Etalage, decoration', $parent, $manager);
        $this->createActivity('Ramonage,nettoyage,entretient de fosse septique et désinsectissation', $parent, $manager);
        $this->createActivity('Soins de beauté', $parent, $manager);
        $this->createActivity('Toilettage d\'animaux de compagnie', $parent, $manager);

        $parent = $this->createActivity('Batiments', null, $manager);

        $this->createActivity('Aménagement, agencement et finition', $parent, $manager);
        $this->createActivity('Couverture, plomberie chauffage', $parent, $manager);
        $this->createActivity('Industries extractives', $parent, $manager);
        $this->createActivity('Maçonnerie et autres travaux de construction', $parent, $manager);
        $this->createActivity('Menuserie,serrurerie', $parent, $manager);
        $this->createActivity('Orpaillage', $parent, $manager);
        $this->createActivity('Preparation des sites et terrassement', $parent, $manager);
        $this->createActivity('Travaux d\'installation électrique et d\'isolation', $parent, $manager);
        $this->createActivity('Ramonage,nettoyage,entretient de fosse septique et désinsectissation', $parent, $manager);
        $this->createActivity('Traveaux sous-marins de forage', $parent, $manager);

        $manager->flush();
    }

    public function createActivity(string $name, Activity $parent = null, ObjectManager $manager)
    {
        $activity = new Activity();
        $activity
            ->setName($name)
            ->setSlug($this->slugger->slug($activity->getName())->lower())
            ->setParent($parent);

        $manager->persist($activity);

        $this->addReference('act-'. $this->counter, $activity);
        $this->counter++;

        $manager->flush();
        return $activity;
    }
    // public function getDependencies():array
    // {
    //     return[
    //         AppFixtures::class
    //     ];
    // }

    
}
