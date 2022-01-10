<?php

namespace App\Entity;

use App\Repository\CommandeMenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeMenuRepository::class)
 */
class CommandeMenu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="commandeMenus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\Column(type="json")
     */
    private $menu = [];

    /**
     * @ORM\Column(type="array")
     */
    private $plats = [];

    public function __construct()
    {
		
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getMenu(): ?array
    {
        return $this->menu;
    }

    public function setMenu(array $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getPlats(): ?array
    {
        return $this->plats;
    }

    public function setPlats(array $plats): self
    {
        $this->plats = $plats;

        return $this;
    }
}
