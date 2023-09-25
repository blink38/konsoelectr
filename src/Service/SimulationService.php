<?php

namespace App\Service;

use App\Engine\SimulationEngine;
use App\Entity\Facturation;
use App\Entity\Import;
use App\Entity\Simulation;
use App\Repository\SimulationRepository;
use Doctrine\ORM\EntityManagerInterface;

class SimulationService
{

    private $repository;
    private $doctrine;
    private $engine;
    private $releveService;


    public function __construct(EntityManagerInterface $em, SimulationRepository $repository, SimulationEngine $engine, ReleveService $releveService)
    {
        $this->doctrine = $em;
        $this->repository = $repository;

        $this->engine = $engine;
        $this->releveService = $releveService;
    }

    public function persist(Simulation $simulation): bool
    {

        try {
            $this->doctrine->persist($simulation);
            $this->doctrine->flush();
            return true;
        } catch (\Exception $e) {
            error_log($e);
            return false;
        }
    }

    public function findById(int $id): ?Simulation
    {
        return $this->repository->find($id);
    }

    public function remove(int $id): bool
    {
        try {
            $simulation = $this->repository->find($id);

            if ($simulation){
                $this->doctrine->remove($simulation);
                $this->doctrine->flush();
                return true;
            }

        } catch (\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function list(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Simulation d'un jeu de données ($releves) sur un scénario de facturation ($facturation)
     * 
     */
    public function simulate(int $id) : ?Simulation
    {

        $simulation = $this->findById($id);

        $releves = $this->releveService->listByImport($simulation->getData());

        $simulation->setResultat(
            $this->engine->simulate($simulation->getFacturation(), $releves)
        );


        return $simulation;
    }

}