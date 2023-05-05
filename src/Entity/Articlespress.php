<?php

namespace App\Entity;

use App\Repository\ArticlespressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


#[Vich\Uploadable]
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


    #[Vich\UploadableField(mapping: "blog", fileNameProperty: "images")]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $updated_At = null;

    #[ORM\Column(options:['default'=>'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_At = null;


    #[ORM\OneToMany(mappedBy: 'Articlepress', targetEntity: Comments::class)]
    private Collection $comment;

    #[ORM\ManyToOne(inversedBy: 'articlespresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ess $ess = null;

    #[ORM\OneToMany(mappedBy: 'articlespress', targetEntity: ArticleCategories::class)]
    private Collection $articlescategories;

    
    #[ORM\OneToMany(mappedBy: 'articlespress', targetEntity: Images::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $images;

    

    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->articlescategories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->updated_At = new \DateTimeImmutable();
    
       
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

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @return  self
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updated_At;
        }
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_At;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_At): self
    {
        $this->updated_At = $updated_At;

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

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setArticlepress($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticlepress() === $this) {
                $image->setArticlepress(null);
            }
        }

        return $this;
    }

    
    
}
