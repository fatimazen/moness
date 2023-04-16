<?php

namespace App\Entity;

use App\Repository\NewsLettersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsLettersRepository::class)]
class NewsLetters
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tile = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sent_At = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'newsLetters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTile(): ?string
    {
        return $this->tile;
    }

    public function setTile(string $tile): self
    {
        $this->tile = $tile;

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

    public function getSentAt(): ?\DateTimeImmutable
    {
        return $this->sent_At;
    }

    public function setSentAt(\DateTimeImmutable $sent_At): self
    {
        $this->sent_At = $sent_At;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
