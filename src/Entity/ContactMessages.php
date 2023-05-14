<?php

namespace App\Entity;

use App\Repository\ContactMessagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ContactMessagesRepository::class)]
class ContactMessages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable:true)]
    #[Assert\Length(min: 2, max:50)]
    private ?string $fullName = null;

    #[ORM\Column(length: 180)]
    #[Assert\Email()]
    #[Assert\Length(min: 2, max:180)]
    private string $email ;

    #[ORM\Column(type:'text')]
    #[Assert\NotBlank()]
    private string $message ;

    #[ORM\Column(length:100, nullable:true)]
    #[Assert\Length(min: 2, max:100)]
    private ?string $sujet= null ;

    #[ORM\Column(options:['default'=>'CURRENT_TIMESTAMP'])]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\ManyToOne(inversedBy: 'contactMessage')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Users $users = null;

    public function __construct()
    {
    
        $this->created_At = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
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

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSujet():? string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }
}
