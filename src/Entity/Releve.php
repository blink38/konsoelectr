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

}
