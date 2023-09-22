<?php

namespace App\Controller;

use App\Bean\Releve;
use App\Entity\Facturation;
use App\Entity\Import;
use App\Entity\Tarif;
use App\Form\FacturationType;
use App\Form\ImportType;
use App\Form\TarifType;
use App\Service\FacturationService;
use App\Service\ImportReleveService;
use App\Service\ImportService;
use App\Service\TarifService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TarifController extends AbstractController
{


    #[Route('/tarif/add/{id}', name: 'app_tarif_add')]
    public function add(Request $request, int $id, TarifService $service, FacturationService $facturationService): Response
    {

        $tarif = new Tarif();

        $tarif->setFacturation($facturationService->findById($id));

        $form = $this->createForm(TarifType::class, $tarif);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $tarif = $form->getData();
            
            $service->persist($tarif);


            return $this->redirectToRoute('app_facturation');

            
        }

        return $this->render('tarif/new.html.twig', [
            'form' => $form,
        ]);

    }

}
