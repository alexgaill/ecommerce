<?php

namespace App\Entity;

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
    private $desc;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $imgSmall;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $race;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $archetype;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $set_name;

        /**
     * @ORM\Column(type="string", length=100)
     */
    private $set_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $set_rarity;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $cost;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $atk;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $def;

    /**
     * @ORM\Column(type="integer", length=2)
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $attribute;

    public function getSlug(): string
    {
     return (new Slugify())->slugify($this->name);
    }

    public function getTypeType(): string
    {
        return self::TYPE[$this->type];
    }

    public function getRarityType(): string
    {
        return self::RARITY[$this->rarity];
    }

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
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     *
     * @return self
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;

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
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     *
     * @return self
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImgSmall()
    {
        return $this->imgSmall;
    }

    /**
     * @param mixed $imgSmall
     *
     * @return self
     */
    public function setImgSmall($imgSmall)
    {
        $this->imgSmall = $imgSmall;

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
        return $this->set_name;
    }

    /**
     * @param mixed $set_name
     *
     * @return self
     */
    public function setSetName($set_name)
    {
        $this->set_name = $set_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetCode()
    {
        return $this->set_code;
    }

    /**
     * @param mixed $set_code
     *
     * @return self
     */
    public function setSetCode($set_code)
    {
        $this->set_code = $set_code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetRarity()
    {
        return $this->set_rarity;
    }

    /**
     * @param mixed $set_rarity
     *
     * @return self
     */
    public function setSetRarity($set_rarity)
    {
        $this->set_rarity = $set_rarity;

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
}
