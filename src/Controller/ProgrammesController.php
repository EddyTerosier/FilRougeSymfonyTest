<?php

namespace App\Controller;

use App\Entity\Programmes;
use App\Form\ProgrammesType;
use App\Repository\ProgrammesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammesController extends AbstractController
{
    #[Route("/programmes", name: "app_programmes")]
    public function index(ProgrammesRepository $repository): Response
    {
        return $this->render("programmes/index.html.twig", [
            "programmes" => $repository->findAll(),
        ]);
    }

    #[Route("programme/nouveau", "programmes.new", methods: ["GET", "POST"])]
    public function new(): Response
    {
        $programmes = new Programmes();
        $form = $this->createForm(ProgrammesType::class, $programmes);

        return $this->render("programmes/new.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
