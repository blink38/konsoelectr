<?php

namespace App\Service;

use App\Entity\Import;
use App\Entity\Releve;
use App\Repository\ReleveRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;

class ReleveService
{

    private $doctrine;
    private $repository;

    public function __construct(EntityManagerInterface $em, ReleveRepository $releveRepository)
    {
        $this->repository = $releveRepository;
        $this->doctrine = $em;
    }

    public function listByImport(Import $import){
    
        return $this->repository->findBy(['import' => $import]);
    }
    

    public function addReleves(array $releves, String $importLibelle): array
    {

        $memory_limit = ini_get('memory_limit');
        // echo "Current memory limit is: " . $memory_limit . "\n";
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '300');


        $import = new Import();
        $import->setLibelle($importLibelle);
        $import->setDate(new \DateTime('now'));
        $this->doctrine->persist($import);
        // $this->doctrine->flush();

        // $this->doctrine->beginTransaction();
        try {
            // $this->doctrine->clear();

            $enbase = [];
            // $batchSize = 10;
            // $count = 0;

            foreach ($releves as $releve) {

            //     if ($count == 0){
            //         $import = $this->doctrine->find(Import::class, $import->getId());
            //     }

                $r = new Releve();
                $r->setConso($releve->getValeur());
                $r->setDate($releve->getHorodate());
                $r->setImport($import);

                $this->doctrine->persist($r);
                $enbase[] = $r;

                // $count++;
                // if ($count >= $batchSize){
                //     $count = 0;
                //     $this->doctrine->flush();
                //     $this->doctrine->clear();
                // }
               
            }
        
            $this->doctrine->flush();
            // $this->doctrine->commit();

        } catch (\Exception $e) {
            error_log($e);
            // $this->doctrine->rollback();
        }

        // echo "Peak memory usage: " . memory_get_peak_usage() . "\n";

        // ini_set('memory_limit', $memory_limit);
        return $enbase;
    }
}
