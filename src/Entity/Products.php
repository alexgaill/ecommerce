<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
    const TYPE =[
        0=> 'Monstre normal',
        1=> 'Monstre à effet',
        2=> 'Magie',
        3=> 'Piège',
        4=> 'Token'
    ];
    const RARITY =[
        0=> 'Commune',
        1=> 'Rare'
    ];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="integer")
     */
    private $rarity;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $abimee;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $occasion;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $correct;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $neuve;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $cost;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $price;

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

    public function getSlug(): string
    {
     return (new Slugify())->slugify($this->name);
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeType(): string
    {
        return self::TYPE[$this->type];
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getRarity(): ?int
    {
        return $this->rarity;
    }

    public function setRarity(int $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getRarityType(): string
    {
        return self::RARITY[$this->rarity];
    }

    public function getAbimee(): ?int
    {
        return $this->abimee;
    }

    public function setAbimee(int $abimee): self
    {
        $this->abimee = $abimee;

        return $this;
    }

    public function getOccasion(): ?int
    {
        return $this->occasion;
    }

    public function setOccasion(int $occasion): self
    {
        $this->occasion = $occasion;

        return $this;
    }

    public function getCorrect(): ?int
    {
        return $this->correct;
    }

    public function setCorrect(int $correct): self
    {
        $this->correct = $correct;

        return $this;
    }

    public function getNeuve(): ?int
    {
        return $this->neuve;
    }

    public function setNeuve(int $neuve): self
    {
        $this->neuve = $neuve;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getFormattedCost(): string {
        return number_format($this->cost, 2, ',', ' ');
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormattedPrice(): string {
        return number_format($this->price, 2, ',', ' ');
    }
}
