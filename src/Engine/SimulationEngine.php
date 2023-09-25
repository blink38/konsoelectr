<?php

namespace App\Engine;

use App\Entity\Facturation;
use App\Entity\Import;
use App\Entity\Releve;
use App\Entity\Tarif;
use Doctrine\Common\Collections\Collection;

class SimulationEngine
{

    /**
     * Simulation d'un jeu de données ($releves) sur un scénario de facturation ($facturation)
     * 
     * @param App\Service\Facturation $facturation 
     * @param Import $datas 
     * @return array|null 
     */

    public function simulate(Facturation $facturation, array $releves): ?array
    {
        $resultats = [];

        $resultats['montant'] = 0;
        $resultats['debug'] = '';


        $tarifs = $facturation->getTarifs()->toArray();

        // prépare les calculs internes pour éviter de les refaire plusieurs fois
        foreach ($tarifs as $tarif) {
            $tarif->prepare();
        }

        $precedent = null;

        foreach ($releves as $releve) {

            // prépare les calculs internes pour éviter de les refaire plusieurs fois
            $releve->prepare();

            if ($precedent != null) {

                $duree = $releve->getTimestamp() - $precedent->getTimestamp();

                // choix du tarif qui s'applique
                $tarif = $this->choixTarif($tarifs, $releve);

                if ($tarif instanceof Tarif) {
                    // connaissant le tarif qui s'applique et la consommation du relevé,
                    // on peut calculer le montant dépensé
                    $montant = $tarif->getTarif() * $releve->getConso() / 1000;

                    $montant = $duree * $montant / 3600;

                    $resultats['montant'] = $montant + $resultats['montant'];

                    $resultats['debug'] .= $releve->getDate()->format("d-m-Y H:i") . " : " . $montant . ' (' . $resultats['montant'] . ') ' . $releve->getConso() . 'W ' . $tarif->getLibelle() . "\n";
                }
            }

            $precedent = $releve;
        }

        return $resultats;
    }



    public function choixTarif(array $tarifs, Releve $releve): ?Tarif
    {

        $selected = [];

        foreach ($tarifs as $tarif) {

            if ($this->estElligible($tarif, $releve)) {

                $selected[$tarif->getPriority()] = $tarif;
            }
        }

        if (count($selected) > 0) {
            // retourne le dernier élement (donc celui avec la plus grande priorité)
            return end($selected);
        }

        return null;
    }


    public function estElligible(Tarif $tarif, Releve $releve): bool
    {

        // comparaison date de releve avec les dates d'application du tarif
        if ($tarif->getDateDebut() != null && $tarif->getDateFin() != null) {
            $resultat = $releve->getDate() >= $tarif->getDateDebut() && $releve->getDate() <= $tarif->getDateFin();

            if ($resultat === false) {
                return false;
            }
        }

        // jours spécifiques d'application
        if (!empty($tarif->getDaysApply())){
            
            $resultat = in_array($releve->getDayApply(), $tarif->getDaysApply());
            if ($resultat === false) {
                return false;
            }
        }


        // comparaison des heures
        $resultat = $releve->getMinutes() >= $tarif->getMinutes_debut() && $releve->getMinutes() <= $tarif->getMinutes_fin();

        if ($resultat === false) {
            return false;
        }

        // comparaison du jour de la semaine
        return $tarif->getJours()[$releve->getJourSemaine()];
    }
}
