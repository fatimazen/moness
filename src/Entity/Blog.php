<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BlogRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;




#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: BlogRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(

    'slug',
    message: 'ce slug existe déjà.'
)]
class Blog
{
    const STATES = ['STATE_DRAFT', 'STATE_PUBLISHED'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column( length: 255, unique: true)]
    #[Assert\NotBlank()]
    private string $title;

    #[ORM\Column( length: 255, unique: true)]
    #[Assert\NotBlank()]
    private string $slug;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private string $author;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    
    #[Vich\UploadableField(mapping: "blog", fileNameProperty: "images")]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'text',)]
    #[Assert\NotBlank()]
    private string $content;

    #[ORM\Column(length: 255)]
    private string $state = Blog::STATES[0];

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $updated_At = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_At = null;


    #[ORM\OneToMany(mappedBy: 'blog', targetEntity: Comments::class)]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'blog')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    #[ORM\OneToMany(mappedBy: 'blog', targetEntity: ArticleCategories::class)]
    private Collection $articlesCategories;

    #[ORM\OneToMany(mappedBy: 'blog', targetEntity: Images::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $images;





    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->articlesCategories = new ArrayCollection();
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_At;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_At): self
    {
        $this->updated_At = $updated_At;

        return $this;
    }

    public function __toString()

    {
        return $this->title;
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
            $comment->setBlog($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBlog() === $this) {
                $comment->setBlog(null);
            }
        }

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

    /**
     * @return Collection<int, ArticleCategories>
     */
    public function getArticlesCategories(): Collection
    {
        return $this->articlesCategories;
    }

    public function addArticlesCategory(ArticleCategories $articlesCategory): self
    {
        if (!$this->articlesCategories->contains($articlesCategory)) {
            $this->articlesCategories->add($articlesCategory);
            $articlesCategory->setBlog($this);
        }

        return $this;
    }

    public function removeArticlesCategory(ArticleCategories $articlesCategory): self
    {
        if ($this->articlesCategories->removeElement($articlesCategory)) {
            // set the owning side to null (unless already changed)
            if ($articlesCategory->getBlog() === $this) {
                $articlesCategory->setBlog(null);
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
            $image->setBlog($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBlog() === $this) {
                $image->setBlog(null);
            }
        }

        return $this;
    }
}
