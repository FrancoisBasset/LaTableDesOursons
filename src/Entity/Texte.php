<?php

namespace App\Entity;

use App\Repository\TexteRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=TexteRepository::class)
 */
class Texte implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="text")
     */
    private $texte_fr;

    /**
     * @ORM\Column(type="text")
     */
    private $texte_en;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getTexteFr(): ?string
    {
        return $this->texte_fr;
    }

    public function setTexteFr(string $texte_fr): self
    {
        $this->texte_fr = $texte_fr;

        return $this;
    }

    public function getTexteEn(): ?string
    {
        return $this->texte_en;
    }

    public function setTexteEn(string $texte_en): self
    {
        $this->texte_en = $texte_en;

        return $this;
    }

	public function jsonSerialize(): mixed
	{
		return [
			'id' => $this->id,
			'position' => $this->position,
			'texte_fr' => $this->texte_fr,
			'texte_en' => $this->texte_en,
		];
	}
}
