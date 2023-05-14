<?php

namespace App\Entity;


use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\ArticlespresseRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ArticlespresseRepository::class)]
#[UniqueEntity(

    'slug',
    message: 'ce slug existe déjà.'
)]
class Articlespresse
{
    const STATES = ['STATE_DRAFT', 'STATE_PUBLISHED'];
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;


    #[Vich\UploadableField(mapping: "articlespresse", fileNameProperty: "image")]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: 'text',)]
    #[Assert\NotBlank()]
    private string $content;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    private string $slug;

    #[ORM\Column(length: 255)]
    private string $state = Articlespresse::STATES[0];

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $updated_At = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_At = null;


    #[ORM\OneToMany(mappedBy: 'articlespresse', targetEntity: Comments::class)]
    private Collection $comment;

    #[ORM\ManyToOne(inversedBy: 'articlespresse')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ess $ess = null;

    #[ORM\OneToMany(mappedBy: 'articlespresse', targetEntity: ArticleCategories::class)]
    private Collection $articlescategories;


    #[ORM\OneToMany(mappedBy: 'articlespresse', targetEntity: Image::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $images;



    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->articlescategories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->updated_At = new \DateTimeImmutable();
        $this->created_At = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->slug = (new Slugify())->slugify($this->title);
    }


    #[ORM\PreUpdate]
    public function preUpdate()

    {
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
    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

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

    public function __toString()

    {
        return $this->title;
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
            $comment->setArticlepresse($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticlepresse() === $this) {
                $comment->setArticlepresse(null);
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
    public function getArticlecategories(): Collection
    {
        return $this->articlescategories;
    }

    public function addArticlecategory(ArticleCategories $articlescategory): self
    {
        if (!$this->articlescategories->contains($articlescategory)) {
            $this->articlescategories->add($articlescategory);
            $articlescategory->setArticlepresse($this);
        }

        return $this;
    }

    public function removeArticlescategory(ArticleCategories $articlescategory): self
    {
        if ($this->articlescategories->removeElement($articlescategory)) {
            // set the owning side to null (unless already changed)
            if ($articlescategory->getArticlepresse() === $this) {
                $articlescategory->setArticlepresse(null);
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

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setArticlepresse($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticlepresse() === $this) {
                $image->setArticlepresse(null);
            }
        }

        return $this;
    }
}
