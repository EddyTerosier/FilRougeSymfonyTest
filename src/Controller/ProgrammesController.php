<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Form\MarkType;
use App\Entity\Programmes;
use App\Form\ProgrammesType;
use App\Repository\MarkRepository;
use App\Repository\ProgrammesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    // #[IsGranted('ROLE_ADMIN')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $programmes = new Programmes();
        $form = $this->createForm(ProgrammesType::class, $programmes);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programmes = $form->getData();
            // $programmes->setUser($this->getUser());

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
    // #[Security("is_granted('ROLE_ADMIN') and admin === programmes.getUser()")]
    // La ligne du dessus permet aux admins qui ont créer un programme de ne modifié que ceux qu'ils ont crée et auncun autre
    // #[IsGranted('ROLE_ADMIN')]
    public function edit(
        Programmes $programmes,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(ProgrammesType::class, $programmes);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    // #[IsGranted('ROLE_ADMIN')]
    public function delete(EntityManagerInterface $manager, Programmes $programmes): Response
    {
        $manager->remove($programmes);
        $manager->flush();

        $this->addFlash(
            "danger",
            "Votre programme a été supprimé avec succès !"
        );

        return $this->redirectToRoute('app_programmes');
    }

    #[Route("/programme/{id}", name: "app_programme_description",methods: ['GET', 'POST'])]
    public function programmeShow(Programmes $programmes, Request $request, MarkRepository $markRepository, EntityManagerInterface $manager): Response
    {
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $mark->setUser($this->getUser())
                ->setProgrammes($programmes);
            $existingMark = $markRepository->findOneBy([
                'user' => $this->getUser(),
                'programmes' => $programmes
            ]);

            if (!$existingMark) {
                $manager->persist($mark);
            } else {
                $existingMark->setMark(
                    $form->getData()->getMark()
                );
            }

            $manager->flush();

            $this->addFlash(
               'success',
               'Votre note a bien été prise en compte Merci !'
            );

            return $this->redirectToRoute('app_programme_description', ['id' => $programmes->getId()]);
        }

        return $this->render("programmes/show.html.twig", [
            "programmes" => $programmes,
            "form" => $form->createView()
        ]);
    }
}
