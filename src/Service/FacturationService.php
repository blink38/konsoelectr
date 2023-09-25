<?php

namespace App\Service;

use App\Entity\Facturation;
use App\Repository\FacturationRepository;
use Doctrine\ORM\EntityManagerInterface;

class FacturationService
{
    private $repository;
    private $doctrine;

    public function __construct(EntityManagerInterface $em, FacturationRepository $repository)
    {
        $this->doctrine = $em;
        $this->repository = $repository;
    }

    public function persist(Facturation $facturation): bool
    {

        try {
            $this->doctrine->persist($facturation);
            $this->doctrine->flush();
            return true;
        } catch (\Exception $e) {
            error_log($e);
            return false;
        }
    }

    public function findById(int $id): ?Facturation
    {
        return $this->repository->find($id);
    }

    public function remove(int $id): bool
    {
        try {
            $facturation = $this->repository->find($id);

            if ($facturation){
                $this->doctrine->remove($facturation);
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
}
