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



    public function getId(): ?int
    {
        return $this->id;
    }

}
