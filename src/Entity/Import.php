<?php

namespace App\Entity;

use App\Repository\ImportRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ImportRepository::class)]
class Import
{

    const FORMAT_DATE = "Y-m-d\TH:i:sO";
    const  SQL_FORMAT_DATE = "Y-m-d H:i:s";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    private int $nbReleves = 0;
    private ?\DateTimeInterface $start = null;
    private ?\DateTimeInterface $end = null;
    
    
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

    /**
     * Get the value of nbReleves
     */ 
    public function getNbReleves() : int
    {
        return $this->nbReleves;
    }

    /**
     * Set the value of nbReleves
     *
     * @return  self
     */ 
    public function setNbReleves(int $nbReleves) : static
    {
        $this->nbReleves = $nbReleves;
        return $this;
    }

    /**
     * Get the value of start
     */ 
    public function getStart() : ?\DateTimeInterface
    {
        return $this->start;
    }

    /**
     * Set the value of start
     *
     * @return  self
     */ 
    public function setStart(\DateTimeInterface|string $start) : static
    {
        if (is_string($start)){
            $this->start = DateTime::createFromFormat(self::SQL_FORMAT_DATE, $start);
        }

        if ($start instanceof \DateTimeInterface){
            $this->start = $start;
        }
        return $this;
    }


    /**
     * Get the value of end
     */ 
    public function getEnd() : ?\DateTimeInterface
    {
        return $this->end;
    }

    /**
     * Set the value of end
     *
     * @return  self
     */ 
    public function setEnd(\DateTimeInterface|string $end) : static
    {
        if (is_string($end)){
            $this->end = DateTime::createFromFormat(self::SQL_FORMAT_DATE, $end);
        }

        if ($end instanceof \DateTimeInterface){
            $this->end = $end;
        }

        return $this;
    }

}
