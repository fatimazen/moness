<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ess;
use App\Entity\Blog;
use App\Entity\Users;
use DateTimeImmutable;
use App\Entity\Comments;
use App\Entity\NewsLetters;
use App\Entity\Articlespresse;
use App\Entity\ContactMessages;
use App\Entity\GeoLocalisationEss;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
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
        for ($i = 1; $i < 30; $i++) {

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
                ->setOpeningHoursMonday(new \DateTime($faker->time('H:i:s')))
                ->setClosingHoursMonday(new \DateTime($faker->time('H:i:s')))
                ->setOpeningHoursTuesday(new \DateTime($faker->time('H:i:s')))
                ->setClosingHoursTuesday(new \DateTime($faker->time('H:i:s')))
                ->setOpeningHoursWednesday(new \DateTime($faker->time('H:i:s')))
                ->setClosingHoursWednesday(new \DateTime($faker->time('H:i:s')))
                ->setOpeningHoursThursday(new \DateTime($faker->time('H:i:s')))
                ->setClosingHoursThursday(new \DateTime($faker->time('H:i:s')))
                ->setOpeningHoursFriday(new \DateTime($faker->time('H:i:s')))
                ->setClosingHoursFriday(new \DateTime($faker->time('H:i:s')))
                ->setOpeningHoursSaturday(new \DateTime($faker->time('H:i:s')))
                ->setClosingHoursSaturday(new \DateTime($faker->time('H:i:s')))
                ->setOpeningHoursSunday(new \DateTime($faker->time('H:i:s')))
                ->setClosingHoursSunday(new \DateTime($faker->time('H:i:s')))
                ->setRegion($faker->randomElement(['occitanie', 'PACA', 'Rhônes Alpes']))
                ->setLabel([$faker->randomElement(['L’AFNOR ', 'ESUS', 'Lucie', 'ISR'])])
                ->setSiretNumber($faker->randomNumber(9) * pow(10, 5) + $faker->randomNumber(5))
                ->setUpdatedAt((DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London"))))
                ->setUsers($faker->randomElement($users));

            // on va chercher une réference d' activité

            $activity = $this->getReference('act-' . rand(1, 27));
            $ess->setActivity($activity);
            // // on va chercher une réference d' activité
            // $this->setReference('i-' . $i, $ess);

            $essS[] = $ess;
            $manager->persist($ess);
        }


        $contactsMessage = [];
        for ($i = 0; $i < 10; $i++) {
            $contactMessage = new ContactMessages();
            $contactMessage
                ->setFullName($faker->name())
                ->setEmail($faker->safeEmail())
                ->setMessage($faker->text(255))
                ->setSujet('demande n°' . ($i + 1))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('2014-06-20 11:45', 'now', 'Europe/London')))
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
                ->setImage("blogtest.jpg")
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
                ->setImage("blogtest.jpg")
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
                ->setActive($faker->boolean())
                ->setApproved(random_int(0, 3) === 0 ? false : true)
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime("2014-06-20 11:45 Europe/London")))
                ->setAuthor($users[mt_rand(0, count($users) - 1)])
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
