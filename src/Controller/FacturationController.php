<?php

namespace App\Controller;

use App\Bean\Releve;
use App\Entity\Facturation;
use App\Entity\Import;
use App\Form\FacturationType;
use App\Form\ImportType;
use App\Service\FacturationService;
use App\Service\ImportReleveService;
use App\Service\ImportService;
use App\Service\TarifService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacturationController extends AbstractController
{

    #[Route('/facturation', name: 'app_facturation')]
    public function index(FacturationService $service): Response
    {

        return $this->render('facturation/index.html.twig', [
            'controller_name' => 'FacturationController',
            'facturations' => $service->list(),

            'form' => $this->createForm(FacturationType::class, null, [ 'action' => $this->generateUrl('app_facturation_new') ])
        ]);
    }


    #[Route('/facturation/delete/{id}', name: 'app_facturation_delete')]
    public function delete(int $id, FacturationService $service): Response
    {
        $service->remove($id);
        return $this->redirectToRoute('app_facturation');
    }

    #[Route('/facturation/show/{id}', name: 'app_facturation_show')]
    public function show(int $id, FacturationService $service, TarifService $tarif): Response
    {

        return $this->render('facturation/show.html.twig', [
            'facturation' => $service->findById($id),
            'tarifs' => $tarif->listByFacturation($id),

        ]);
    }


    #[Route('/facturation/new', name: 'app_facturation_new')]
    public function add(Request $request, FacturationService $service): Response
    {

        $facturation = new Facturation();

        $form = $this->createForm(FacturationType::class, $facturation);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $facturation = $form->getData();
            
            $service->persist($facturation);


        }


        return $this->redirectToRoute('app_facturation');
    }
}
