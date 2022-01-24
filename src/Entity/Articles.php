<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;


    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="date")
     */
    private $createdDate;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $metaDescription;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageEnAvant;

    /**
     * @Assert\Length(
     *     min=10,
     *     max=80,
     *     minMessage="la legende est trop courte",
     *     maxMessage="la legende est trop longue")
     * @ORM\Column(type="string", length=255)
     */
    private $LegendeImageEnAvant;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Categorie;

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

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

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

    public function getImageEnAvant(): ?string
    {
        return $this->imageEnAvant;
    }

    public function setImageEnAvant(string $imageEnAvant): self
    {
        $this->imageEnAvant = $imageEnAvant;

        return $this;
    }

    public function getLegendeImageEnAvant(): ?string
    {
        return $this->LegendeImageEnAvant;
    }

    public function setLegendeImageEnAvant(string $LegendeImageEnAvant): self
    {
        $this->LegendeImageEnAvant = $LegendeImageEnAvant;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categories $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }
}
