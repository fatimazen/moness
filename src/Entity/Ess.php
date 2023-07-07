<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EssRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;



#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: EssRepository::class)]
#[UniqueEntity('nameStructure')]
class Ess
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $nameStructure = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 5)]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255, type: 'json')]
    private ?array $sectorActivity = null;

    #[ORM\Column(length: 255, type: 'json')]
    private ?array $legalStatus = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\Length(
        min: 10,
        max: 13,
    )]
    #[ORM\Column(length: 20)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;


    #[Vich\UploadableField(mapping: "ess", fileNameProperty: "image")]
    private ?File $imageFile = null;


    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $updated_At = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $webSite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $socialNetworks = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingHoursMonday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingHoursMonday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingHoursTuesday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingHoursTuesday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingHoursWednesday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingHoursWednesday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingHoursThursday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingHoursThursday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingHoursFriday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingHoursFriday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingHoursSaturday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingHoursSaturday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingHoursSunday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingHoursSunday = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $label = null;

    #[ORM\Column(length: 14)]
    private ?string $siretNumber = null;

    #[ORM\ManyToOne(inversedBy: 'ess', cascade: ['persist'])]
    private ?Users $users = null;

    #[ORM\OneToMany(mappedBy: 'ess', targetEntity: Comments::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'ess', targetEntity: Favoris::class)]
    private Collection $favoris;




    #[ORM\OneToOne(mappedBy: 'ess', cascade: ['persist', 'remove'])]
    private ?GeoLocalisationEss $geoLocalisationEss = null;

    #[ORM\ManyToOne(inversedBy: 'ess')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activity $activity = null;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->updated_At = new \DateTimeImmutable();
        $this->created_At = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNameStructure(): ?string
    {
        return $this->nameStructure;
    }

    public function setNameStructure(string $nameStructure): self
    {
        $this->nameStructure = $nameStructure;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getSectorActivity(): ?array
    {
        return $this->sectorActivity;
    }

    public function setSectorActivity(array $sectorActivity): self
    {
        $this->sectorActivity = $sectorActivity;

        return $this;
    }

    public function getLegalStatus(): ?array
    {
        return $this->legalStatus;
    }

    public function setLegalStatus(array $legalStatus): self
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }


    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @return  self
     */
    public function setImageFile(File $images = null)
    {
        $this->imageFile = $images;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($images) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updated_At;
        }
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_At;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_At): self
    {
        $this->updated_At = new \DateTimeImmutable();

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_At;
    }

    public function setCreatedAt(\DateTimeImmutable $created_At): self
    {
        $this->created_At = $created_At;

        return $this;
    }

    public function getWebSite(): ?string
    {
        return $this->webSite;
    }

    public function setWebSite(?string $webSite): self
    {
        $this->webSite = $webSite;

        return $this;
    }

    public function getSocialNetworks(): ?string
    {
        return $this->socialNetworks;
    }

    public function setSocialNetworks(?string $socialNetworks): self
    {
        $this->socialNetworks = $socialNetworks;

        return $this;
    }

    public function getOpeningHoursMonday(): ?\DateTimeInterface
    {
        return $this->openingHoursMonday;
    }

    public function setOpeningHoursMonday(\DateTimeInterface $openingHoursMonday): self
    {
        $this->openingHoursMonday = $openingHoursMonday;

        return $this;
    }

    public function getClosingHoursMonday(): ?\DateTimeInterface
    {
        return $this->closingHoursMonday;
    }

    public function setClosingHoursMonday(\DateTimeInterface $closingHoursMonday): self
    {
        $this->closingHoursMonday = $closingHoursMonday;

        return $this;
    }

    public function getOpeningHoursTuesday(): ?\DateTimeInterface
    {
        return $this->openingHoursTuesday;
    }

    public function setOpeningHoursTuesday(\DateTimeInterface $openingHoursTuesday): self
    {
        $this->openingHoursTuesday = $openingHoursTuesday;

        return $this;
    }

    public function getClosingHoursTuesday(): ?\DateTimeInterface
    {
        return $this->closingHoursTuesday;
    }

    public function setClosingHoursTuesday(\DateTimeInterface $closingHoursTuesday): self
    {
        $this->closingHoursTuesday = $closingHoursTuesday;

        return $this;
    }

    public function getOpeningHoursWednesday(): ?\DateTimeInterface
    {
        return $this->openingHoursWednesday;
    }

    public function setOpeningHoursWednesday(\DateTimeInterface $openingHoursWednesday): self
    {
        $this->openingHoursWednesday = $openingHoursWednesday;

        return $this;
    }

    public function getClosingHoursWednesday(): ?\DateTimeInterface
    {
        return $this->closingHoursWednesday;
    }

    public function setClosingHoursWednesday(\DateTimeInterface $closingHoursWednesday): self
    {
        $this->closingHoursWednesday = $closingHoursWednesday;

        return $this;
    }

    public function getOpeningHoursThursday(): ?\DateTimeInterface
    {
        return $this->openingHoursThursday;
    }

    public function setOpeningHoursThursday(\DateTimeInterface $openingHoursThursday): self
    {
        $this->openingHoursThursday = $openingHoursThursday;

        return $this;
    }

    public function getClosingHoursThursday(): ?\DateTimeInterface
    {
        return $this->closingHoursThursday;
    }

    public function setClosingHoursThursday(\DateTimeInterface $closingHoursThursday): self
    {
        $this->closingHoursThursday = $closingHoursThursday;

        return $this;
    }

    public function getOpeningHoursFriday(): ?\DateTimeInterface
    {
        return $this->openingHoursFriday;
    }

    public function setOpeningHoursFriday(\DateTimeInterface $openingHoursFriday): self
    {
        $this->openingHoursFriday = $openingHoursFriday;

        return $this;
    }

    public function getClosingHoursFriday(): ?\DateTimeInterface
    {
        return $this->closingHoursFriday;
    }

    public function setClosingHoursFriday(\DateTimeInterface $closingHoursFriday): self
    {
        $this->closingHoursFriday = $closingHoursFriday;

        return $this;
    }

    public function getOpeningHoursSaturday(): ?\DateTimeInterface
    {
        return $this->openingHoursSaturday;
    }

    public function setOpeningHoursSaturday(\DateTimeInterface $openingHoursSaturday): self
    {
        $this->openingHoursSaturday = $openingHoursSaturday;

        return $this;
    }

    public function getClosingHoursSaturday(): ?\DateTimeInterface
    {
        return $this->closingHoursSaturday;
    }

    public function setClosingHoursSaturday(\DateTimeInterface $closingHoursSaturday): self
    {
        $this->closingHoursSaturday = $closingHoursSaturday;

        return $this;
    }

    public function getOpeningHoursSunday(): ?\DateTimeInterface
    {
        return $this->openingHoursSunday;
    }

    public function setOpeningHoursSunday(\DateTimeInterface $openingHoursSunday): self
    {
        $this->openingHoursSunday = $openingHoursSunday;

        return $this;
    }

    public function getClosingHoursSunday(): ?\DateTimeInterface
    {
        return $this->closingHoursSunday;
    }

    public function setClosingHoursSunday(\DateTimeInterface $closingHoursSunday): self
    {
        $this->closingHoursSunday = $closingHoursSunday;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getLabel(): ?array
    {
        return $this->label;
    }

    public function setLabel(?array $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getSiretNumber(): ?string
    {
        return $this->siretNumber;
    }

    public function setSiretNumber(string $siretNumber): self
    {
        $this->siretNumber = $siretNumber;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setEss($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEss() === $this) {
                $comment->setEss(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favoris>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->setEss($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getEss() === $this) {
                $favori->setEss(null);
            }
        }

        return $this;
    }


    public function getGeoLocalisationEss(): ?GeoLocalisationEss
    {
        return $this->geoLocalisationEss;
    }

    public function setGeoLocalisationEss(GeoLocalisationEss $geoLocalisationEss): self
    {
        // set the owning side of the relation if necessary
        if ($geoLocalisationEss->getEss() !== $this) {
            $geoLocalisationEss->setEss($this);
        }

        $this->geoLocalisationEss = $geoLocalisationEss;

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }
}
