<?php

namespace App\Bean;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Releve
{

    private $date;
    private $conso;

    /**
     * @SerializedName("date")
     * @param mixed $date
     */
    #[SerializedName('Horodate')]
    public function setHorodate($date) : static {

        $this->date = $date;
        return $this;

    }

    public function getHorodate() : String
    {
        return $this->date;
    }

    public function getValeur() : int
    {
        if (is_string($this->conso)) {
            return (int) $this->conso;
        }
        return $this->conso;
    }

    /**
     * @SerializedName("conso")
     * @param mixed $conso
     */   
     #[SerializedName('Valeur')]
    public function setValeur($conso) : static {

        $this->conso = $conso;
        return $this;
    }

}