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

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Comments::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: NewsLetters::class)]
    private Collection $newsLetters;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Blog::class)]
    private Collection $blog;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: NewsLetters::class)]
    private Collection $newsletters;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Favoris::class)]
    private Collection $favoris;

    public function __construct()
    {
        $this->ess = new ArrayCollection();
        $this->contactMessage = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->newsLetters = new ArrayCollection();
        $this->blog = new ArrayCollection();
        $this->newsletters = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    
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
            $ess->setUser($this);
        }

        return $this;
    }

    public function removeEss(Ess $ess): self
    {
        if ($this->ess->removeElement($ess)) {
            // set the owning side to null (unless already changed)
            if ($ess->getUser() === $this) {
                $ess->setUser(null);
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
            $comment->setUsers($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUsers() === $this) {
                $comment->setUsers(null);
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
            $favori->setUser($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getUser() === $this) {
                $favori->setUser(null);
            }
        }

        return $this;
    }

}
