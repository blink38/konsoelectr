<?php

namespace App\Controller;

use App\Entity\Simulation;
use App\Form\SimulationType;
use App\Service\FacturationService;
use App\Service\SimulationService;
use App\Service\TarifService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimulationController extends AbstractController
{

    #[Route('/simulation', name: 'app_simulation')]
    public function index(SimulationService $service): Response
    {

        return $this->render('simulation/index.html.twig', [
            'controller_name' => 'FacturationController',
            'simulations' => $service->list(),

            'form' => $this->createForm(SimulationType::class, null, [ 'action' => $this->generateUrl('app_simulation_add') ])
        ]);
    }


    #[Route('/simulation/add', name: 'app_simulation_add')]
    public function add(Request $request, SimulationService $service): Response
    {

        $simulation = new Simulation();

        $form = $this->createForm(SimulationType::class, $simulation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $simulation = $form->getData();
            $simulation->setDate(new \DateTime('now'));

            $service->persist($simulation);
        }

        return $this->redirectToRoute('app_simulation');
    }

    #[Route('/simulation/execute/{id}', name: 'app_simulation_execute')]
    public function execute(int $id, SimulationService $service): Response
    {

        $simulation = $service->simulate($id);
        $service->persist($simulation);
        
        return $this->render('simulation/resultat.html.twig', [
            'simulation' => $simulation
        ]);
    }

    #[Route('/simulation/show/{id}', name: 'app_simulation_show')]
    public function show(int $id, SimulationService $service): Response
    {
        $simulation = $service->findById($id);
        
        return $this->render('simulation/resultat.html.twig', [
            'simulation' => $simulation
        ]);
    }


    #[Route('/simulation/delete/{id}', name: 'app_simulation_delete')]
    public function delete(int $id, SimulationService $service): Response
    {
        $service->remove($id);
        return $this->redirectToRoute('app_simulation');
    }
}
