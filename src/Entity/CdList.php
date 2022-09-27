<?php

namespace App\Entity;

use App\Repository\CdListRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CdListRepository::class)]
class CdList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $interpret = null;

    #[ORM\Column(length: 255)]
    private ?string $album = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?\DateTime $rls = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::DECIMAL, length: 255)]
    #[Assert\Range( notInRangeMessage: "This value should be between {{ min }} and {{ max }}", min: 0, max: 100)]
    private ?string $rating = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInterpret(): ?string
    {
        return $this->interpret;
    }

    public function setInterpret(string $interpret): self
    {
        $this->interpret = $interpret;

        return $this;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(string $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getRls(): ?\DateTime
    {
        return $this->rls;
    }

    public function setRls(\DateTime $rls): self
    {
        $this->rls = $rls;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(string $rating): self
    {
        $this->rating = $rating;

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
}
