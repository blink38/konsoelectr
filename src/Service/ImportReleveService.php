<?php

namespace App\Service;

use App\Bean\Releve;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class ImportReleveService {

    private $releveService;


    public function __construct(ReleveService $releveService){
        
        $this->releveService = $releveService;
    }


    public function importRelevesFromFileContent(String $data, String $libelle) : array{
        

        $releves = $this->parseRelevesFromData($data, Releve::class);

        return $this->releveService->addReleves($releves, $libelle);

    }



    public function parseRelevesFromData(String $data, String $classname) : array {

        $data = $this->skipFirstLines($data);
        
        $encoders = [new CsvEncoder()];

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        
        // $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $normalizers = [new GetSetMethodNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        try {
            $results = $serializer->deserialize($data, $classname . '[]','csv',
                [   'as_collection' => true,
                    CsvEncoder::DELIMITER_KEY => ';',
                    AbstractNormalizer::GROUPS => [ "allowed" ],
                    AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => true]);

            return $results;

        } catch (\Exception $e){
            echo $e;
        }
        
        return [];
    }


    /**
     * Lit le contenu à importer et enleve les premières lignes avant la ligne "Horodate;Valeur"
     * 
     * @param string $data 
     * @return string 
     */
    private function skipFirstLines(String $data) : String
    {   
        $result = '';
        $started = false;

        $line = strtok($data, PHP_EOL);

        while ($line !== FALSE){

            if ($started ){
                $result .= $line . PHP_EOL;
            } else {

                if (str_starts_with($line, 'Horodate;Valeur')){
                    $result .= $line . PHP_EOL;
                    $started = true;
                }
            }

            $line = strtok(PHP_EOL);
        }

        strtok('','');

        return $result;
    }

}