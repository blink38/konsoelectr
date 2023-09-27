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


    #[Route('/tarif/duplicate/{facturation}/{id}', name: 'app_tarif_duplicate')]
    public function duplicate(int $facturation, int $id, TarifService $service): Response
    {

        $tarif = $service->findById($id);

        $duplicate = $service->duplicate($id);


        if ($duplicate !== null){
            return $this->redirectToRoute('app_tarif_edit', [ 'id' => $duplicate->getId()]);
        }

        return $this->redirectToRoute('app_facturation_show', [ 'id' => $facturation]);
    }


    #[Route('/tarif/delete/{id}', name: 'app_tarif_delete')]
    public function delete(int $id, TarifService $service): Response
    {

        $tarif = $service->findById($id);
        $service->remove($id);
        
        return $this->redirectToRoute('app_facturation_show', [ 'id' => $tarif->getFacturation()->getId()]);
    }

    #[Route('/tarif/add/{facturation_id}', name: 'app_tarif_add')]
    public function add(Request $request, int $facturation_id, TarifService $service, FacturationService $facturationService): Response
    {

        $tarif = new Tarif();
        $tarif->setFacturation($facturationService->findById($facturation_id));

        return $this->addOrEdit($request, $tarif, $service);
    }


    #[Route('/tarif/edit/{id}', name: 'app_tarif_edit')]
    public function edit(Request $request, int $id, TarifService $service): Response
    {
        $tarif = $service->findById($id);
        return $this->addOrEdit($request, $tarif, $service);
    }


    private function addOrEdit(Request $request, Tarif $tarif, TarifService $service) : Response
    {
        $form = $this->createForm(TarifType::class, $tarif);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $tarif = $form->getData();
            
            $service->persist($tarif);


            return $this->redirectToRoute('app_facturation_show', [ 'id' => $tarif->getFacturation()->getId()]);

            
        }

        return $this->render('tarif/new.html.twig', [
            'form' => $form,
        ]);

    }

}
