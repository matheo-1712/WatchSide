<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $nom_utilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $mot_de_passe = null;

    /**
     * @var Collection<int, Location>
     */
    #[ORM\OneToMany(targetEntity: Location::class, mappedBy: 'id_user')]
    private Collection $locations;

    /**
     * @var Collection<int, Favoris>
     */
    #[ORM\OneToMany(targetEntity: Favoris::class, mappedBy: 'id_user')]
    private Collection $favoris;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'id_user')]
    private Collection $notes;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nom_utilisateur;
    }

    public function setNomUtilisateur(string $nom_utilisateur): static
    {
        $this->nom_utilisateur = $nom_utilisateur;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }
   public function setMotDePasse(string $mot_de_passe): static
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

   /**
    * @return Collection<int, Location>
    */
   public function getLocations(): Collection
   {
       return $this->locations;
   }

   public function addLocation(Location $location): static
   {
       if (!$this->locations->contains($location)) {
           $this->locations->add($location);
           $location->setIdUser($this);
       }

       return $this;
   }

   public function removeLocation(Location $location): static
   {
       if ($this->locations->removeElement($location)) {
           // set the owning side to null (unless already changed)
           if ($location->getIdUser() === $this) {
               $location->setIdUser(null);
           }
       }

       return $this;
   }

   /**
    * @return Collection<int, Favoris>
    */
   public function getFavoris(): Collection
   {
       return $this->favoris;
   }

   public function addFavori(Favoris $favori): static
   {
       if (!$this->favoris->contains($favori)) {
           $this->favoris->add($favori);
           $favori->setIdUser($this);
       }

       return $this;
   }

   public function removeFavori(Favoris $favori): static
   {
       if ($this->favoris->removeElement($favori)) {
           // set the owning side to null (unless already changed)
           if ($favori->getIdUser() === $this) {
               $favori->setIdUser(null);
           }
       }

       return $this;
   }

   /**
    * @return Collection<int, Note>
    */
   public function getNotes(): Collection
   {
       return $this->notes;
   }

   public function addNote(Note $note): static
   {
       if (!$this->notes->contains($note)) {
           $this->notes->add($note);
           $note->setIdUser($this);
       }

       return $this;
   }

   public function removeNote(Note $note): static
   {
       if ($this->notes->removeElement($note)) {
           // set the owning side to null (unless already changed)
           if ($note->getIdUser() === $this) {
               $note->setIdUser(null);
           }
       }

       return $this;
   }
}
