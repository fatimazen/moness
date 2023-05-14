<?php

namespace App\Entity;

use App\Repository\ArticleCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ArticleCategoriesRepository::class)]
class ArticleCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'articleCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categories = null;

    #[ORM\ManyToOne(inversedBy: 'articlescategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Articlespresse $articlepresse = null;

    #[ORM\ManyToOne(inversedBy: 'articlesCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Blog $blog = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getArticlepresse(): ?Articlespresse
    {
        return $this->articlepresse;
    }

    public function setArticlepresse(?Articlespresse $articlepresse): self
    {
        $this->articlepresse = $articlepresse;

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
