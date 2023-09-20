<?php

namespace App\Service;

use App\Bean\Releve;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class ImportReleveService {



    public function importRelevesFromFileContent(String $data, String $classname) : array{

        // $handle = fopen($file, 'r');

        // $data = fgetcsv($handle, null, ';');

        $encoders = [new CsvEncoder()];

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $normalizers = [new GetSetMethodNormalizer(), new ArrayDenormalizer()];
        //new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter),new ArrayDenormalizer()];


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

}