<?php

namespace App\Entity;

use DateTime;
use DateInterval;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Nullable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
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

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeImmutable $created_At ;

    #[ORM\Column(nullable:true)]
    private ?bool $is_abonneNewsLetter = null;

    #[ORM\Column(length: 255)]
    private ?string $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Ess::class, cascade:['remove'])]
    private ?Collection $ess;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: ContactMessages::class)]
    private Collection $contactMessage;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comments::class)]
    private Collection $comments;

    // #[ORM\OneToMany(mappedBy: 'users', targetEntity: NewsLetters::class)]
    // private Collection $newsLetters;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Blog::class)]
    private Collection $blog;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: NewsLetters::class)]
    private Collection $newsletters;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Favoris::class)]
    private Collection $favoris;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tokenRegistration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable:true)]
    private ?DateTimeInterface $tokenRegistrationLifeTime = null;

    #[ORM\Column]
    private bool $isVerfied = false;

    
    
    public function __construct()
    {
        $this->ess = new ArrayCollection();
        $this->contactMessage = new ArrayCollection();
        $this->comments = new ArrayCollection();
        // $this->newsLetters = new ArrayCollection();
        $this->blog = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->created_At = new \DateTimeImmutable();
        $this->isVerfied = false;
        $this->tokenRegistrationLifeTime =(new DateTime('now'))->add(new DateInterval("P1D"));

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

    public function getCreatedAt(): \DateTimeImmutable
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
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Blog>
     */
    public function getBlog(): Collection
    {
        return $this->blog;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blog->contains($blog)) {
            $this->blog->add($blog);
            $blog->setUsers($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blog->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getUsers() === $this) {
                $blog->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NewsLetters>
     */
    public function getNewsletters(): Collection
    {
        return $this->newsletters;
    }

    public function addNewsletter(NewsLetters $newsletter): self
    {
        if (!$this->newsletters->contains($newsletter)) {
            $this->newsletters->add($newsletter);
            $newsletter->setUsers($this);
        }

        return $this;
    }

    public function removeNewsletter(NewsLetters $newsletter): self
    {
        if ($this->newsletters->removeElement($newsletter)) {
            // set the owning side to null (unless already changed)
            if ($newsletter->getUsers() === $this) {
                $newsletter->setUsers(null);
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
            $favori->setUsers($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed) 
            if ($favori->getUsers() === $this) {
                $favori->setUsers(null);
            }
        }

        return $this;
    }

    // public function isIsSubscribed(): ?bool
    // {
    //     return $this->isSubscribed;
    // }

    // public function setIsSubscribed(?bool $isSubscribed): self
    // {
    //     $this->isSubscribed = $isSubscribed;

    //     return $this;
    // }

    // public function isVerified(): bool
    // {
    //     return $this->isVerified;
    // }
    // public function setIsVerified(?bool $isVerified): self
    // {
    //     $this->isVerified = $isVerified;
    
    //     return $this;
    // }

    public function getTokenRegistration(): ?string
    {
        return $this->tokenRegistration;
    }

    public function setTokenRegistration(?string $tokenRegistration): self
    {
        $this->tokenRegistration = $tokenRegistration;

        return $this;
    }

    public function getTokenRegistrationLifeTime(): ?\DateTimeInterface
    {
        return $this->tokenRegistrationLifeTime;
    }

    public function setTokenRegistrationLifeTime(\DateTimeInterface $tokenRegistrationLifeTime): self
    {
        $this->tokenRegistrationLifeTime = $tokenRegistrationLifeTime;

        return $this;
    }

    public function isIsVerfied(): ?bool
    {
        return $this->isVerfied;
    }

    public function setIsVerfied(bool $isVerfied): self
    {
        $this->isVerfied = $isVerfied;

        return $this;
    }
    public function __toString()
    {
        return $this->firstName.' '.$this->lastName;
    }

}
