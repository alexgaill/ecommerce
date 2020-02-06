<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="listCommandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $commandeDate;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $statut;

    /**
     * @ORM\Column(type="integer")
     */
    private $poids;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $typePaiement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCommande", mappedBy="commande_id")
     */
    private $listLignesCommande;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $livraison;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tarifLivraison;

    /**
     * @ORM\Column(type="float")
     */
    private $montantTotal;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $typeLivraison;

    public function __construct()
    {
        $this->listLignesCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCommandeDate(): ?\DateTimeInterface
    {
        return $this->commandeDate;
    }

    public function setCommandeDate(\DateTimeInterface $commandeDate): self
    {
        $this->commandeDate = $commandeDate;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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

    public function getTypePaiement(): ?string
    {
        return $this->typePaiement;
    }

    public function setTypePaiement(string $typePaiement): self
    {
        $this->typePaiement = $typePaiement;

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
            $listLignesCommande->setCommandeId($this);
        }

        return $this;
    }

    public function removeListLignesCommande(LigneCommande $listLignesCommande): self
    {
        if ($this->listLignesCommande->contains($listLignesCommande)) {
            $this->listLignesCommande->removeElement($listLignesCommande);
            // set the owning side to null (unless already changed)
            if ($listLignesCommande->getCommandeId() === $this) {
                $listLignesCommande->setCommandeId(null);
            }
        }

        return $this;
    }

    public function getLivraison(): ?string
    {
        return $this->livraison;
    }

    public function setLivraison(string $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getTarifLivraison(): ?float
    {
        return $this->tarifLivraison;
    }

    public function setTarifLivraison(?float $tarifLivraison): self
    {
        $this->tarifLivraison = $tarifLivraison;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getTypeLivraison(): ?string
    {
        return $this->typeLivraison;
    }

    public function setTypeLivraison(?string $typeLivraison): self
    {
        $this->typeLivraison = $typeLivraison;

        return $this;
    }
}
