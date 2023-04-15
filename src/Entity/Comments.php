<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    #[ORM\Column(options:['default'=>'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\ManyToMany(targetEntity: Articlespress::class, mappedBy: 'comments')]
    private Collection $articlespresses;

    public function __construct()
    {
        $this->articlespresses = new ArrayCollection();
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

    /**
     * @return Collection<int, Articlespress>
     */
    public function getArticlespresses(): Collection
    {
        return $this->articlespresses;
    }

    public function addArticlespress(Articlespress $articlespress): self
    {
        if (!$this->articlespresses->contains($articlespress)) {
            $this->articlespresses->add($articlespress);
            $articlespress->addComment($this);
        }

        return $this;
    }

    public function removeArticlespress(Articlespress $articlespress): self
    {
        if ($this->articlespresses->removeElement($articlespress)) {
            $articlespress->removeComment($this);
        }

        return $this;
    }
}
