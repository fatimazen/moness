<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $comment = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\ManyToOne(inversedBy: 'comments', targetEntity: Users::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Users $author;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Articlespresse $articlepresse = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Ess $ess = null;


    #[ORM\ManyToOne(inversedBy: 'comments', targetEntity: Blog::class)]
    #[ORM\JoinColumn(nullable: true)]
    private Blog $blog;

    #[ORM\Column(type: 'boolean')]
    private ?bool $active = false;

    #[ORM\Column(type: 'boolean')]
    private ?bool $approved = false;


    public function __construct()
    {

        $this->created_At = new DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

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

    public function getAuthor(): ?Users
    {
        return $this->author;
    }

    public function setAuthor(?Users $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getArticlepresse(): ?Articlespresse
    {
        return $this->articlepresse;
    }

    public function setArticlepresse(?Articlespresse $Articlepresse): self
    {
        $this->articlepresse = $Articlepresse;

        return $this;
    }

    public function getEss(): ?Ess
    {
        return $this->ess;
    }

    public function setEss(?Ess $ess): self
    {
        $this->ess = $ess;

        return $this;
    }



    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function setBlog(?Blog $blog): self
    {
        $this->blog = $blog;

        return $this;
    }
   
}
