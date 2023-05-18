<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use Faker\Factory;
use App\Entity\Users;
use App\Entity\Ess;
use App\Entity\Articlespresse;
use App\Entity\Blog;
use App\Entity\Comments;
use App\Entity\ContactMessages;
use App\Entity\GeoLocalisationEss;
use App\Entity\NewsLetters;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $users[] = $admin;
        $manager->persist($admin);


        for ($i = 0; $i < 10; $i++) {

            $user = new Users();
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
        }



        $essS = [];
        for ($i = 0; $i < 20; $i++) {

            $ess = new Ess();
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
                ->setPhoneNumber(substr($faker->phoneNumber(), 0, 10))
                ->setImage($faker->imageUrl(640, 480, 'company', true))
                ->setWebSite($faker->url())
                ->setSocialNetworks($faker->url())
                ->setActivity($faker->randomElement([1, 2, 3, 4, 5]))
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
                ->setLabel([$faker->randomElement(['L’AFNOR ', 'ESUS', 'Lucie', 'ISR'])])
                ->setSiretNumber($faker->randomNumber())
                ->setUpdatedAt((DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London"))))
                ->setUser($faker->randomElement($users));

            $essS[] = $ess;
            $manager->persist($ess);
        }


        $contactsMessage = [];
        for ($i = 0; $i < 10; $i++) {

            $contactMessage = new ContactMessages;
            $contactMessage
                ->setFullName($faker->name())
                ->setEmail($faker->safeEmail())
                ->setMessage($faker->text(255))
                ->setSujet($faker->randomElement(['demande n°' . ($i + 1)]))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setUsers($faker->randomElement($users));

            $contactsMessage[] = $contactMessage;
            $manager->persist($contactMessage);
        }

        $blogs = [];
        for ($i = 0; $i < 10; $i++) {
            $blog = new Blog;
            $blog
                ->setTitle($faker->sentence())
                ->setAuthor($faker->name())
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setImage('blogtest.jpg')
                ->setContent($faker->text(255))
                ->setUpdatedAt((DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London"))))
                ->setState(mt_rand(0, 2) === 1 ? Blog::STATES[0] : Blog::STATES[1])

                ->setUsers($faker->randomElement($users));
            $manager->persist($blog);
            $blogs[] = $blog;
        }

        $articlespresses = [];
        for ($i = 0; $i < 10; $i++) {
            $articlepresse = new Articlespresse;
            $articlepresse
                ->setTitle($faker->sentence())
                ->setAuthor($faker->name())
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setImage('blogtest.jpg')
                ->setContent($faker->text(255))
                ->setUpdatedAt((DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London"))))
                ->setEss($faker->randomElement($essS))
                ->setState(mt_rand(0, 2) === 1 ? Articlespresse::STATES[0] : Articlespresse::STATES[1]);

            $manager->persist($articlepresse);
            $articlespresses[] = $articlepresse;
        }
        $comments = [];
        for ($i = 0; $i < 30; $i++) {
            $comment = new Comments();
            $comment
                ->setComment($faker->text())
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setUsers($faker->randomElement($users))
                ->setArticlepresse($faker->randomElement($articlespresses))
                ->setEss($faker->randomElement($essS))
                ->setBlog($faker->randomElement($blogs));


            $manager->persist($comment);
            $comments[] = $comment;
        }
        $newsletters = [];
        for ($i = 0; $i < 10; $i++) {
            $newsletter = new NewsLetters();
            $newsletter
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setContent($faker->text(255))
                ->setUsers($faker->randomElement($users));

            $manager->persist($newsletter);
            $newsletters[] = $newsletter;
        }
        $geolocalisations = [];
        foreach ($essS as $ess) {

            $geolocalisation = new GeoLocalisationEss();
            $geolocalisation
                ->setLatitude($faker->latitude(-90, 90))
                ->setLongitude($faker->longitude(-180, 180))
                ->setEss($ess);

            $manager->persist($geolocalisation);
            $geolocalisations[] = $geolocalisation;
        }



        $manager->flush();
    }
}