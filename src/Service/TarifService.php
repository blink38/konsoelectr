<?php

namespace App\Service;

use App\Entity\Tarif;
use App\Repository\TarifRepository;
use Doctrine\ORM\EntityManagerInterface;

class TarifService
{
    private $repository;
    private $doctrine;

    public function __construct(EntityManagerInterface $em, TarifRepository $repository)
    {
        $this->doctrine = $em;
        $this->repository = $repository;
    }

    public function persist(Tarif $tarif): bool
    {

        try {
            $this->doctrine->persist($tarif);
            $this->doctrine->flush();
            return true;
        } catch (\Exception $e) {
            error_log($e);
            return false;
        }
    }

    public function findById(int $id): ?Tarif
    {
        return $this->repository->find($id);
    }

    public function remove(int $id): bool
    {
        try {
            $tarif = $this->repository->find($id);

            if ($tarif){
                $this->doctrine->remove($tarif);
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

    public function listByFacturation($id): array
    {
        return $this->repository->findByFacturationId($id);
    }
}
