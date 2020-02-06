<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneCommandeRepository")
 */
class LigneCommande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="listLignesCommande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products", inversedBy="listLignesCommande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product_id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $setCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $new;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $correct;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $occasion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $abimee;

    /**
     * @ORM\Column(type="integer")
     */
    private $poids;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="float")
     */
    private $prixUnitaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandeId(): ?commande
    {
        return $this->commande_id;
    }

    public function setCommandeId(?commande $commande_id): self
    {
        $this->commande_id = $commande_id;

        return $this;
    }

    public function getProductId(): ?products
    {
        return $this->product_id;
    }

    public function setProductId(?products $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSetCode(): ?string
    {
        return $this->setCode;
    }

    public function setSetCode(string $setCode): self
    {
        $this->setCode = $setCode;

        return $this;
    }

    public function getNew(): ?int
    {
        return $this->new;
    }

    public function setNew(?int $new): self
    {
        $this->new = $new;

        return $this;
    }

    public function getCorrect(): ?int
    {
        return $this->correct;
    }

    public function setCorrect(?int $correct): self
    {
        $this->correct = $correct;

        return $this;
    }

    public function getOccasion(): ?int
    {
        return $this->occasion;
    }

    public function setOccasion(?int $occasion): self
    {
        $this->occasion = $occasion;

        return $this;
    }

    public function getAbimee(): ?int
    {
        return $this->abimee;
    }

    public function setAbimee(?int $abimee): self
    {
        $this->abimee = $abimee;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }
}
