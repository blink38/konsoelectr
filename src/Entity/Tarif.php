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
    private ?bool $lundi = true;

    #[ORM\Column]
    private ?bool $mardi = true;

    #[ORM\Column]
    private ?bool $mercredi = true;

    #[ORM\Column]
    private ?bool $jeudi = true;

    #[ORM\Column]
    private ?bool $vendredi = true;

    #[ORM\Column]
    private ?bool $samedi = true;

    #[ORM\Column]
    private ?bool $dimanche = true;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column]
    private ?float $tarif = null;

    #[ORM\Column]
    private ?int $priority = 0;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_debut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_fin = null;

    #[ORM\ManyToOne(targetEntity: Facturation::class, inversedBy: 'tarifs')]
    private ?Facturation $facturation = null;


    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $days = null;
    

    private int $minutes_debut = 0;
    private int $minutes_fin = 0;
    private array $jours = [];

    private array $daysApply = [];


    public function duplicate(Tarif $tarif) : static 
    {
        $this->libelle = $tarif->getLibelle() . " (copy)";
        $this->lundi = $tarif->isLundi();
        $this->mardi = $tarif->isMardi();
        $this->mercredi = $tarif->isMercredi();
        $this->jeudi = $tarif->isJeudi();
        $this->vendredi = $tarif->isVendredi();
        $this->samedi = $tarif->isSamedi();
        $this->dimanche = $tarif->isDimanche();

        $this->date_debut = $tarif->getDateDebut();
        $this->date_fin = $tarif->getDateFin();

        $this->tarif = $tarif->getTarif();
        $this->priority = $tarif->getPriority();
        $this->heure_debut = $tarif->getHeureDebut();
        $this->heure_fin = $tarif->getHeureFin();
        $this->facturation = $tarif->getFacturation();
        $this->days = $tarif->getDays();

        return $this;
    }

    public function prepare(): void
    {
        $this->jours[0] = false;
        $this->jours[1] = $this->isLundi();
        $this->jours[2] = $this->isMardi();
        $this->jours[3] = $this->isMercredi();
        $this->jours[4] = $this->isJeudi();
        $this->jours[5] = $this->isVendredi();
        $this->jours[6] = $this->isSamedi();
        $this->jours[7] = $this->isDimanche();

        $start_h = (int) $this->getHeureDebut()->format('G');
        $start_m = (int) $this->getHeureDebut()->format('i');
        $this->minutes_debut = $start_h * 60 + $start_m;

        $end_h = (int) $this->getHeureFin()->format('G');
        $end_m = (int) $this->getHeureFin()->format('i');
        $this->minutes_fin = $end_h * 60 + $end_m;

        if (!empty($this->days)){

            $start = new \DateTime('1970-01-01');

            foreach (explode(',', $this->days) as $d){

                $dat = \DateTime::createFromFormat("d-m-Y", $d);

                $this->daysApply[] = $dat->diff($start)->format('%a');
            }
        }
    }


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
    public function getLundi(): ?bool
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
    public function getMardi(): ?bool
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
    public function getMercredi(): ?bool
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
    public function getJeudi(): ?bool
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
    public function getVendredi(): ?bool
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

    public function getSamedi(): ?bool
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
    public function getDimanche(): ?bool
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

    public function setDateDebut(?\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): static
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

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getMinutes_debut(): int
    {
        return $this->minutes_debut;
    }

    public function getMinutes_fin(): int
    {
        return $this->minutes_fin;
    }
    public function getJours(): array
    {
        return $this->jours;
    }

    public function getDays() : ?string
    {
        return $this->days;
    }

    public function setDays($days_apply): static
    {
        $this->days = $days_apply;
        return $this;
    }

    public function getDaysApply(): array
    {
        return $this->daysApply;
    }
}
