<?php

namespace App\DataFixtures;

use App\Entity\Users;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Base;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
    }
    public function load(ObjectManager $manager): void
    {


        $faker = Factory::create('fr_FR');
    

        // $users = [];
        for ($i = 0; $i < 10; $i++) {

            $user = new Users;
            $user
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->safeEmail())
                ->setPassword($this->passwordEncoder->hashPassword($user, 'password'))
                ->setBirthdate($faker->date() )               
                ->setIsAbonneNewsLetter($faker->boolean())
                ->setGender($faker->randomElement([null ||'male'|| 'female']))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setRoles(['ROLE_USER']);



            // $users[] = $user;
            $manager->persist($user);
            // $users[] = $user;
        }

        $admin = new Users;
        $admin
            ->setFirstName('fatima')
            ->setLastName('yakhlef')
            ->setEmail('fatimazen24@gmail.fr')
            ->setPassword($this->passwordEncoder->hashPassword($admin, 'Yakhlef.24'))
            ->setBirthdate($faker->date() )               
            ->setIsAbonneNewsLetter($faker->boolean())
            ->setGender('male')
            ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        

        $manager->flush();
    }
}
