<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Stock;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock
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
    private $stockType;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $new;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $correct;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $occasion;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $abimee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products", inversedBy="stocksList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entry", mappedBy="id_stock", orphanRemoval=true)
     */
    private $entries;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockType(): ?string
    {
        return $this->stockType;
    }

    public function setStockType(string $stockType): self
    {
        $this->stockType = $stockType;

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

    public function getCardId(): ?Products
    {
        return $this->card_id;
    }

    public function setCardId(?Products $card_id): self
    {
        $this->card_id = $card_id;

        return $this;
    }

    /**
     * @return Collection|Entry[]
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(Entry $entry): self
    {
        if (!$this->entries->contains($entry)) {
            $this->entries[] = $entry;
            $entry->setIdStock($this);
        }

        return $this;
    }

    public function removeEntry(Entry $entry): self
    {
        if ($this->entries->contains($entry)) {
            $this->entries->removeElement($entry);
            // set the owning side to null (unless already changed)
            if ($entry->getIdStock() === $this) {
                $entry->setIdStock(null);
            }
        }

        return $this;
    }
}
