<?php

namespace App\Bean;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups;

class Releve
{

    private $date;
    private $conso;


    /**
     * @SerializedName("date")
     * @param mixed $date
     */
    #[SerializedName('date')]
    public function setDate($date) : static {

        $this->date = $date;
        return $this;

    }

    public function getDate()
    {
        return $this->date;
    }

    public function getConso(){
        return $thise->conso;
    }

    /**
     * @SerializedName("conso")
     * @param mixed $conso
     */   
     #[SerializedName('conso')]


    public function setConso($conso) : static {

        $this->conso = $conso;
        return $this;
    }

}