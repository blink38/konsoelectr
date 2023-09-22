<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifRepository::class)]
class Tarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?bool $lundi = null;

    #[ORM\Column]
    private ?bool $mardi = null;

    #[ORM\Column]
    private ?bool $mercredi = null;

    #[ORM\Column]
    private ?bool $jeudi = null;

    #[ORM\Column]
    private ?bool $vendredi = null;

    #[ORM\Column]
    private ?bool $samedi = null;

    #[ORM\Column]
    private ?bool $dimanche = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column]
    private ?float $tarif = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_debut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_fin = null;

    #[ORM\ManyToOne]
    private ?Facturation $facturation = null;

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

    public function isLundi(): ?bool
    {
        return $this->lundi;
    }

    public function setLundi(bool $lundi): static
    {
        $this->lundi = $lundi;

        return $this;
    }

    public function isMardi(): ?bool
    {
        return $this->mardi;
    }

    public function setMardi(bool $mardi): static
    {
        $this->mardi = $mardi;

        return $this;
    }

    public function isMercredi(): ?bool
    {
        return $this->mercredi;
    }

    public function setMercredi(bool $mercredi): static
    {
        $this->mercredi = $mercredi;

        return $this;
    }

    public function isJeudi(): ?bool
    {
        return $this->jeudi;
    }

    public function setJeudi(bool $jeudi): static
    {
        $this->jeudi = $jeudi;

        return $this;
    }

    public function isVendredi(): ?bool
    {
        return $this->vendredi;
    }

    public function setVendredi(bool $vendredi): static
    {
        $this->vendredi = $vendredi;

        return $this;
    }

    public function isSamedi(): ?bool
    {
        return $this->samedi;
    }

    public function setSamedi(bool $samedi): static
    {
        $this->samedi = $samedi;

        return $this;
    }

    public function isDimanche(): ?bool
    {
        return $this->dimanche;
    }

    public function setDimanche(bool $dimanche): static
    {
        $this->dimanche = $dimanche;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): static
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): static
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getFacturation(): ?Facturation
    {
        return $this->facturation;
    }

    public function setFacturation(?Facturation $facturation): static
    {
        $this->facturation = $facturation;

        return $this;
    }
}
