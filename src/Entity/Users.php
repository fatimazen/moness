<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type:'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(options:['default'=>'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\Column]
    private ?bool $is_abonneNewsLetter = null;

    #[ORM\Column(length: 255)]
    private ?string $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Ess::class)]
    private Collection $ess;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: ContactMessages::class)]
    private Collection $contactMessage;

    public function __construct()
    {
        $this->ess = new ArrayCollection();
        $this->contactMessage = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function isIsAbonneNewsLetter(): ?bool
    {
        return $this->is_abonneNewsLetter;
    }

    public function setIsAbonneNewsLetter(bool $is_abonneNewsLetter): self
    {
        $this->is_abonneNewsLetter = $is_abonneNewsLetter;

        return $this;
    }

    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    public function setBirthdate(string $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, Ess>
     */
    public function getEss(): Collection
    {
        return $this->ess;
    }

    public function addEss(Ess $ess): self
    {
        if (!$this->ess->contains($ess)) {
            $this->ess->add($ess);
            $ess->setUsers($this);
        }

        return $this;
    }

    public function removeEss(Ess $ess): self
    {
        if ($this->ess->removeElement($ess)) {
            // set the owning side to null (unless already changed)
            if ($ess->getUsers() === $this) {
                $ess->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContactMessages>
     */
    public function getContactMessage(): Collection
    {
        return $this->contactMessage;
    }

    public function addContactMessage(ContactMessages $contactMessage): self
    {
        if (!$this->contactMessage->contains($contactMessage)) {
            $this->contactMessage->add($contactMessage);
            $contactMessage->setUsers($this);
        }

        return $this;
    }

    public function removeContactMessage(ContactMessages $contactMessage): self
    {
        if ($this->contactMessage->removeElement($contactMessage)) {
            // set the owning side to null (unless already changed)
            if ($contactMessage->getUsers() === $this) {
                $contactMessage->setUsers(null);
            }
        }

        return $this;
    }
}
