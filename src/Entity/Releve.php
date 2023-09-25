<?php

namespace App\Entity;

use App\Repository\ReleveRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReleveRepository::class)]
class Releve
{

    const FORMAT_DATE = "Y-m-d\TH:i:sO";
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $conso = null;

    #[ORM\ManyToOne( cascade : ['remove' ] )]
    private ?Import $import = null;

    private int $minutes = 0;
    private int $jourSemaine = 0;
    private int $timestamp = 0;

    private int $dayApply = 0;


    public function prepare(): void
    {

        $start_h = (int) $this->getDate()->format('G');
        $start_m = (int) $this->getDate()->format('i');
        $this->minutes = $start_h * 60 + $start_m;

        $this->jourSemaine = (int) $this->getDate()->format('N');
        $this->timestamp = (int) $this->getDate()->format('U');

        $start = new \DateTime('1970-01-01');

        $this->dayApply =  $this->getDate()->diff($start)->format('%a');

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface|string $date): static
    {
        if (is_string($date)){
            $this->date = DateTime::createFromFormat(self::FORMAT_DATE, $date);
        }

        if ($date instanceof \DateTimeInterface){
            $this->date = $date;
        }

        return $this;
    }

    public function getConso(): ?int
    {
        return $this->conso;
    }

    public function setConso(int $conso): static
    {
        $this->conso = $conso;

        return $this;
    }

    public function getImport(): ?Import
    {
        return $this->import;
    }

    public function setImport(?Import $import): static
    {
        $this->import = $import;

        return $this;
    }

    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function getJourSemaine() : int
    {
        return $this->jourSemaine;
    }

    public function getTimestamp() : int
    {
        return $this->timestamp;
    }

    public function getDayApply(): int
    {
        return $this->dayApply;
    }
}
