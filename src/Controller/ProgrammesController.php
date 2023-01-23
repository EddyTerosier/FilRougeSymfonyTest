<?php

namespace App\Controller;

use App\Repository\ProgrammesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammesController extends AbstractController
{
    #[Route('/programmes', name: 'app_programmes')]
    public function index(ProgrammesRepository $repository): Response
    {
        $programmes = $repository->findAll();
        return $this->render('programmes/index.html.twig', [
            'programmes' => $programmes
        ]);
    }
}
