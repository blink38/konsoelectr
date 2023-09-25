<?php

namespace App\Entity;

use App\Repository\FacturationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturationRepository::class)]
class Facturation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(targetEntity: Tarif::class, mappedBy: 'facturation')]
    private Collection $tarifs;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get the value of tarifs
     */ 
    public function getTarifs() : Collection
    {
        return $this->tarifs;
    }

    /**
     * Set the value of tarifs
     *
     * @return  self
     */ 
    public function setTarifs($tarifs) : static
    {
        $this->tarifs = $tarifs;
        return $this;
    }
}
