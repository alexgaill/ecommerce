<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $race;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $archetype;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $setName;

        /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $setCode;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $setRarity;

    /**
     * @ORM\Column(type="float", options={"default": 0}, nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="float", options={"default": 0}, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $atk;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $def;

    /**
     * @ORM\Column(type="integer", length=2, nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $attribute;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="card_id", orphanRemoval=true)
     */
    private $stocksList;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCommande", mappedBy="product_id")
     */
    private $listLignesCommande;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Images", mappedBy="products_id")
     */
    private $images;

    public function __construct()
    {
        $this->stocksList = new ArrayCollection();
        $this->listLignesCommande = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getSlug(): string
    {
     return (new Slugify())->slugify($this->name);
    }

    // public function getTypeType(): string
    // {
    //     return self::TYPE[$this->type];
    // }

    // public function getRarityType(): string
    // {
    //     return self::RARITY[$this->rarity];
    // }

    public function getFormattedCost(): string {
        return number_format($this->cost, 2, ',', ' ');
    }

    public function getFormattedPrice(): string {
        return number_format($this->price, 2, ',', ' ');
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param mixed $race
     *
     * @return self
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArchetype()
    {
        return $this->archetype;
    }

    /**
     * @param mixed $archetype
     *
     * @return self
     */
    public function setArchetype($archetype)
    {
        $this->archetype = $archetype;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetName()
    {
        return $this->setName;
    }

    /**
     * @param mixed $setName
     *
     * @return self
     */
    public function setSetName($setName)
    {
        $this->setName = $setName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetCode()
    {
        return $this->setCode;
    }

    /**
     * @param mixed $setCode
     *
     * @return self
     */
    public function setSetCode($setCode)
    {
        $this->setCode = $setCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetRarity()
    {
        return $this->setRarity;
    }

    /**
     * @param mixed $setRarity
     *
     * @return self
     */
    public function setSetRarity($setRarity)
    {
        $this->setRarity = $setRarity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     *
     * @return self
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAtk()
    {
        return $this->atk;
    }

    /**
     * @param mixed $atk
     *
     * @return self
     */
    public function setAtk($atk)
    {
        $this->atk = $atk;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDef()
    {
        return $this->def;
    }

    /**
     * @param mixed $def
     *
     * @return self
     */
    public function setDef($def)
    {
        $this->def = $def;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     *
     * @return self
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     *
     * @return self
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocksList(): Collection
    {
        return $this->stocksList;
    }

    public function addStocksList(Stock $stocksList): self
    {
        if (!$this->stocksList->contains($stocksList)) {
            $this->stocksList[] = $stocksList;
            $stocksList->setCardId($this);
        }

        return $this;
    }

    public function removeStocksList(Stock $stocksList): self
    {
        if ($this->stocksList->contains($stocksList)) {
            $this->stocksList->removeElement($stocksList);
            // set the owning side to null (unless already changed)
            if ($stocksList->getCardId() === $this) {
                $stocksList->setCardId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LigneCommande[]
     */
    public function getListLignesCommande(): Collection
    {
        return $this->listLignesCommande;
    }

    public function addListLignesCommande(LigneCommande $listLignesCommande): self
    {
        if (!$this->listLignesCommande->contains($listLignesCommande)) {
            $this->listLignesCommande[] = $listLignesCommande;
            $listLignesCommande->setProductId($this);
        }

        return $this;
    }

    public function removeListLignesCommande(LigneCommande $listLignesCommande): self
    {
        if ($this->listLignesCommande->contains($listLignesCommande)) {
            $this->listLignesCommande->removeElement($listLignesCommande);
            // set the owning side to null (unless already changed)
            if ($listLignesCommande->getProductId() === $this) {
                $listLignesCommande->setProductId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->addProductsId($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            $image->removeProductsId($this);
        }

        return $this;
    }
}
