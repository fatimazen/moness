<?php

namespace App\Entity;

use App\Repository\ArticlespressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlespressRepository::class)]
class Articlespress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(options:['default'=>'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_At = null;


    #[ORM\OneToMany(mappedBy: 'Articlepress', targetEntity: Comments::class)]
    private Collection $comment;

    #[ORM\ManyToOne(inversedBy: 'articlespresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ess $ess = null;

    #[ORM\OneToMany(mappedBy: 'articlespress', targetEntity: ArticleCategories::class)]
    private Collection $articlescategories;

    

    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->articlescategories = new ArrayCollection();
       
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

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
     * @return Collection<int, Comments>
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment->add($comment);
            $comment->setArticlepress($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticlepress() === $this) {
                $comment->setArticlepress(null);
            }
        }

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

    /**
     * @return Collection<int, ArticleCategories>
     */
    public function getArticlescategories(): Collection
    {
        return $this->articlescategories;
    }

    public function addArticlescategory(ArticleCategories $articlescategory): self
    {
        if (!$this->articlescategories->contains($articlescategory)) {
            $this->articlescategories->add($articlescategory);
            $articlescategory->setArticlespress($this);
        }

        return $this;
    }

    public function removeArticlescategory(ArticleCategories $articlescategory): self
    {
        if ($this->articlescategories->removeElement($articlescategory)) {
            // set the owning side to null (unless already changed)
            if ($articlescategory->getArticlespress() === $this) {
                $articlescategory->setArticlespress(null);
            }
        }

        return $this;
    }

    
    
}
