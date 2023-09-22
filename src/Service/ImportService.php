<?php

namespace App\Service;

use App\Repository\ImportRepository;
use Doctrine\ORM\EntityManagerInterface;

class ImportService
{

    private $repository;

    public function __construct(ImportRepository $repository)
    {
        $this->repository = $repository;
    }


    public function remove(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function list(): array
    {
        return $this->repository->findAll();
    }


    public function infos(): array
    {

        $infos = $this->repository->findAll();

        foreach ($infos as $info) {

            $data = $this->repository->infoImport($info->getId());

            if ($data['count'] > 0) {
                $info->setStart($data['start']);
                $info->setEnd($data['end']);
            }
            $info->setNbReleves($data['count']);
        }


        return $infos;
    }
}
