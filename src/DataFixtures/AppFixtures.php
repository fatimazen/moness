<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use App\Entity\ContactMessages;
use App\Entity\Ess;
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

        $gender = $faker->randomElement(['male', 'female']);

        $users = [];
        for ($i = 0; $i < 10; $i++) {


            $user = new Users;
            $user
                ->setFirstName($faker->firstName($gender))
                ->setLastName($faker->lastName())
                ->setEmail($faker->safeEmail())
                ->setPassword($this->passwordEncoder->hashPassword($user, 'password'))
                ->setBirthdate($faker->date())
                ->setIsAbonneNewsLetter($faker->boolean())
                ->setGender($gender)
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setRoles(['ROLE_USER']);



            $users[] = $user;
            $manager->persist($user);
            $users[] = $user;
        }

        $admin = new Users;
        $admin
            ->setFirstName('fatima')
            ->setLastName('yakhlef')
            ->setEmail('fatimazen24@gmail.fr')
            ->setPassword($this->passwordEncoder->hashPassword($admin, 'Yakhlef.24'))
            ->setBirthdate($faker->date())
            ->setIsAbonneNewsLetter($faker->boolean())
            ->setGender('female')
            ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);


        $esss = [];
        for ($i = 0; $i < 10; $i++) {

            $ess = new Ess;
            $ess
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->safeEmail())
                ->setNameStructure($faker->company())
                ->setAdress($faker->address())
                ->setCity($faker->city())
                ->setZipCode(str_replace(' ', '', $faker->postcode))
                ->setSectorActivity($faker->jobTitle())
                ->setLegalStatus($faker->randomElement(['SARL', 'SA', 'EURL', 'SASU', 'SAS']))
                ->setDescription($faker->text(255))
                ->setPhoneNumber(substr($faker->e164phoneNumber(), 0, 13))
                ->setImage($faker->imageUrl(640, 480, 'company', true))
                ->setWebSite($faker->url())
                ->setSocialNetworks($faker->url())
                ->setOpeningHoursMonday(new \Datetime($faker->time('H:i:s')))
                ->setClosingHoursMonday(new \Datetime($faker->time('H:i:s')))
                ->setOpeningHoursTuesday(new \Datetime($faker->time('H:i:s')))
                ->setClosingHoursTuesday(new \Datetime($faker->time('H:i:s')))
                ->setOpeningHoursWednesday(new \Datetime($faker->time('H:i:s')))
                ->setClosingHoursWednesday(new \Datetime($faker->time('H:i:s')))
                ->setOpeningHoursThursday(new \Datetime($faker->time('H:i:s')))
                ->setClosingHoursThursday(new \Datetime($faker->time('H:i:s')))
                ->setOpeningHoursFriday(new \Datetime($faker->time('H:i:s')))
                ->setClosingHoursFriday(new \Datetime($faker->time('H:i:s')))
                ->setOpeningHoursSaturday(new \Datetime($faker->time('H:i:s')))
                ->setClosingHoursSaturday(new \Datetime($faker->time('H:i:s')))
                ->setOpeningHoursSunday(new \Datetime($faker->time('H:i:s')))
                ->setClosingHoursSunday(new \Datetime($faker->time('H:i:s')))
                ->setRegion($faker->randomElement(['occitanie', 'PACA', 'Rhônes Alpes']))
                ->setLabel($faker->randomElement(['L’AFNOR ', 'ESUS', 'Lucie', 'ISR']))
                ->setSiretNumber($faker->randomNumber())
                ->setUsers($faker->randomElement($users));

            $esss[] = $ess;
            $manager->persist($ess);
            $esss[] = $ess;


            $contactMessages = [];
            for ($i = 0; $i < 10; $i++) {

                $contactMessage = new ContactMessages;
                $contactMessage
                ->setFirstName($faker->firstName())
                ->setEmail($faker->safeEmail())
                ->setMessage($faker->text(255))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setUsers($faker->randomElement($users));

                $contactMessages[] = $contactMessage;
                $manager->persist($contactMessage);
                $contactMessages[] = $contactMessage;


            }
            $blog = [];
            for ($i = 0; $i < 10; $i++) {
                $blog = new Blog;
                $blog
                ->setTitle($faker->sentence())
                ->setAuthor($faker->name())
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setImage($faker->imageUrl(640, 480, 'company', true))
                ->setContent($faker->text(255))
                ->setUsers($faker->randomElement($users));
                
                $manager->persist($blog);
            
            }


            $manager->flush();
        }
    }
}
