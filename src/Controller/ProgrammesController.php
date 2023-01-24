<?php

namespace App\Controller;

use App\Entity\Programmes;
use App\Form\ProgrammesType;
use App\Repository\ProgrammesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammesController extends AbstractController
{
    /**
     * This controller display all programs
     *
     * @param ProgrammesRepository $repository
     * @param Request $request
     * @return Response
     */
    #[Route("/programmes", name: "app_programmes")]
    public function index(ProgrammesRepository $repository): Response
    {
        return $this->render("programmes/index.html.twig", [
            "programmes" => $repository->findAll(),
        ]);
    }

    /**
     * This controller show a form which create a program
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[
        Route(
            "programmes/nouveau",
            name: "programmes_new",
            methods: ["GET", "POST"]
        )
    ]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $programmes = new Programmes();
        $form = $this->createForm(ProgrammesType::class, $programmes);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get("image")->getData();
            if ($imageFile) {
                $originalFilename = pathinfo(
                    $imageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = transliterator_transliterate(
                    "Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()",
                    $originalFilename
                );
                $newFilename =
                    $safeFilename .
                    "-" .
                    uniqid() .
                    "." .
                    $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter("upload_directory"),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $programmes->setImage($newFilename);
            }
            $programmes = $form->getData();

            $manager->persist($programmes); // comme le commit la consigne de l'envoyer est faite
            $manager->flush(); // comme le push on envoie vrmt les données

            $this->addFlash(
                "success",
                "Votre programme a été créé avec succès !"
            );

            return $this->redirectToRoute("app_programmes");
        }

        return $this->render("programmes/new.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * This controller show
     */
    #[
        Route(
            "/programmes/edition/{id}",
            name: "programmes_edit",
            methods: ["GET", "POST"]
        )
    ]
    public function edit(
        Programmes $programmes,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(ProgrammesType::class, $programmes);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get("image")->getData();
            if ($imageFile) {
                $originalFilename = pathinfo(
                    $imageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = transliterator_transliterate(
                    "Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()",
                    $originalFilename
                );
                $newFilename =
                    $safeFilename .
                    "-" .
                    uniqid() .
                    "." .
                    $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter("upload_directory"),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $programmes->setImage($newFilename);
            }
            $programmes = $form->getData();

            $manager->persist($programmes); // comme le commit la consigne de l'envoyer est faite
            $manager->flush(); // comme le push on envoie vrmt les données

            $this->addFlash(
                "success",
                "Votre programme a été modifié avec succès !"
            );

            return $this->redirectToRoute("app_programmes");
        }

        $form = $this->createForm(ProgrammesType::class, $programmes);

        return $this->render("programmes/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }
    #[Route("/programmes/suppression/{id}", name: "programmes_delete", methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Programmes $programmes): Response
    {
        if(!$programmes){
            $this->addFlash(
                "success",
                "Le programme en question n'a pas été trouvé !"
            );
        return $this->redirectToRoute('app_programmes');
        }
        $manager->remove($programmes);
        $manager->flush();

        $this->addFlash(
            "danger",
            "Votre programme a été supprimé avec succès !"
        );

        return $this->redirectToRoute('app_programmes');
    }
}
