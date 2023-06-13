<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Cocur\Slugify\Slugify;
use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Activity
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100,)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    private string $slug;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'activity')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $activity;

    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: Ess::class)]
    private Collection $ess;

    public function __construct()
    {
        $this->activity = new ArrayCollection();
        $this->ess = new ArrayCollection();
    }
    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->slug = (new Slugify())->slugify($this->name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getActivity(): Collection
    {
        return $this->activity;
    }

    public function addActivity(self $activity): self
    {
        if (!$this->activity->contains($activity)) {
            $this->activity->add($activity);
            $activity->setParent($this);
        }

        return $this;
    }

    public function removeActivity(self $activity): self
    {
        if ($this->activity->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getParent() === $this) {
                $activity->setParent(null);
            }
        }

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
            $ess->setActivity($this);
        }

        return $this;
    }

    public function removeEss(Ess $ess): self
    {
        if ($this->ess->removeElement($ess)) {
            // set the owning side to null (unless already changed)
            if ($ess->getActivity() === $this) {
                $ess->setActivity(null);
            }
        }

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
}
