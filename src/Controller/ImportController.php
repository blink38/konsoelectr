<?php

namespace App\Controller;

use App\Bean\Releve;
use App\Entity\Import;
use App\Form\ImportType;
use App\Service\ImportReleveService;
use App\Service\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{

    #[Route('/import', name: 'app_import')]
    public function index(ImportService $service): Response
    {

        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
            'imports' => $service->infos(),
        ]);
    }


    #[Route('/import/delete/{id}', name: 'app_import_delete')]
    public function delete(int $id, ImportService $service): Response
    {

       $service->remove($id);

        return $this->redirectToRoute('app_import');
    }

    #[Route('/import/new', name: 'app_import_new')]
    public function add(Request $request, ImportReleveService $service): Response
    {

        $import = new Import();
        $import->setDate(new \DateTime('now'));

        $form = $this->createForm(ImportType::class, $import);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $import = $form->getData();

            $file = $form->get('file')->getData();

            if ($file->isValid()){

                // $moved = $file->move(sys_get_temp_dir(), $file->getClientOriginalName());
                
                $lines = $service->importRelevesFromFileContent($file->getcontent(), $import->getLibelle());

                return $this->render('import/new.result.html.twig', [
                    'message' => 'Import ' . $import->getLibelle() . ' effectué avec succès. ' . count($lines) . ' relevés importés' 
                ]);

            }
            // ... perform some action, such as saving the task to the database

        }


        return $this->render('import/new.html.twig', [
            'form' => $form,
        ]);
    }
}
