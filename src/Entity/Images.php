<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImagesRepository")
 */
class Images
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlSmall;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Products", inversedBy="images")
     */
    private $products_id;

    public function __construct()
    {
        $this->products_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrlSmall(): ?string
    {
        return $this->urlSmall;
    }

    public function setUrlSmall(?string $urlSmall): self
    {
        $this->urlSmall = $urlSmall;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProductsId(): Collection
    {
        return $this->products_id;
    }

    public function addProductsId(Products $productsId): self
    {
        if (!$this->products_id->contains($productsId)) {
            $this->products_id[] = $productsId;
        }

        return $this;
    }

    public function removeProductsId(Products $productsId): self
    {
        if ($this->products_id->contains($productsId)) {
            $this->products_id->removeElement($productsId);
        }

        return $this;
    }
}
