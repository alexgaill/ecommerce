<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntryRepository")
 */
class Entry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Arrivage", inversedBy="entries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_arrivage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="entries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_stock;

    /**
     * @ORM\Column(type="integer")
     */
    private $new;

    /**
     * @ORM\Column(type="integer")
     */
    private $correct;

    /**
     * @ORM\Column(type="integer")
     */
    private $occasion;

    /**
     * @ORM\Column(type="integer")
     */
    private $abimee;

    /**
     * @ORM\Column(type="float")
     */
    private $totalTTC;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdArrivage(): ?Arrivage
    {
        return $this->id_arrivage;
    }

    public function setIdArrivage(?Arrivage $id_arrivage): self
    {
        $this->id_arrivage = $id_arrivage;

        return $this;
    }

    public function getIdStock(): ?Stock
    {
        return $this->id_stock;
    }

    public function setIdStock(?Stock $id_stock): self
    {
        $this->id_stock = $id_stock;

        return $this;
    }

    public function getNew(): ?int
    {
        return $this->new;
    }

    public function setNew(int $new): self
    {
        $this->new = $new;

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

    public function getOccasion(): ?int
    {
        return $this->occasion;
    }

    public function setOccasion(int $occasion): self
    {
        $this->occasion = $occasion;

        return $this;
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

    public function getTotalTTC(): ?float
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(float $totalTTC): self
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }
}
