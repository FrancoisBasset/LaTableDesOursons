<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlatRepository::class)
 */
class Plat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=CategoriePlat::class, mappedBy="plats")
     */
    private $categoriePlats;

    public function __construct()
    {
        $this->categoriePlats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    /**
     * @return Collection|CategoriePlat[]
     */
    public function getCategoriePlats(): Collection
    {
        return $this->categoriePlats;
    }

    public function addCategoriePlat(CategoriePlat $categoriePlat): self
    {
        if (!$this->categoriePlats->contains($categoriePlat)) {
            $this->categoriePlats[] = $categoriePlat;
            $categoriePlat->addPlat($this);
        }

        return $this;
    }

    public function removeCategoriePlat(CategoriePlat $categoriePlat): self
    {
        if ($this->categoriePlats->removeElement($categoriePlat)) {
            $categoriePlat->removePlat($this);
        }

        return $this;
    }
}
