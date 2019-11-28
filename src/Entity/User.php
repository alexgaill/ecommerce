<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields= {"email"},
 * message= "Cet email est déjà utilisé."
 * )
 */
class User implements UserInterface
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=150)
     * * @Assert\Email(
     *     message = "L'email: {{ value }} n'est pas valide.",
     *     checkMX = true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
    * @Assert\EqualTo(propertyPath="password", message="Attention les mots de passe ne sont pas identiques")
    */
    public $password_verify;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $code_validation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valide;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Arrivage", mappedBy="id_client", orphanRemoval=true)
     */
    private $listArrivages;

    public function __construct()
    {
        $this->listArrivages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCodeValidation(): ?string
    {
        return $this->code_validation;
    }

    public function setCodeValidation(string $code_validation): self
    {
        $this->code_validation = $code_validation;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Arrivage[]
     */
    public function getListArrivages(): Collection
    {
        return $this->listArrivages;
    }

    public function addListArrivage(Arrivage $listArrivage): self
    {
        if (!$this->listArrivages->contains($listArrivage)) {
            $this->listArrivages[] = $listArrivage;
            $listArrivage->setIdClient($this);
        }

        return $this;
    }

    public function removeListArrivage(Arrivage $listArrivage): self
    {
        if ($this->listArrivages->contains($listArrivage)) {
            $this->listArrivages->removeElement($listArrivage);
            // set the owning side to null (unless already changed)
            if ($listArrivage->getIdClient() === $this) {
                $listArrivage->setIdClient(null);
            }
        }

        return $this;
    }

    public function createCode($nom, $createdAt)
    {
        return hash('sha256', ($nom.$createdAt));
    }

    public function eraseCredentials() {}

    public function getSalt() {}

    public function getRoles() {
        if ( $this->id == 1 || $this->id == 6) {
            return ['ROLE_ADMIN'];
        } else {
            return ['ROLE_USER'];
        }
        
    }
    public function getUsername() {}
}
