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

class IndexController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {

        return $this->render('index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }


}
