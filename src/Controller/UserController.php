<?php

namespace App\Controller;

use App\Entity\Programmes;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[
        Route(
            "/utilisateur/edition/{id}",
            name: "app_user",
            methods: ["GET", "POST"]
        )
    ]
    // #[IsGranted('ROLE_USER')]
    public function index(
        User $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute("app_login");
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute("app_home");
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $hasher->isPasswordValid(
                    $user,
                    $form->getData()->getPlainPassword()
                )
            ) {
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();

                $this->addFlash("success", "Les infos ont été modifiées");
                return $this->redirectToRoute("app_account", ['id' => $user->getId()]);
            } else {
                $this->addFlash("warning", "Le mot de passe est incorrect");
            }
        }

        return $this->render("user/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    #[
        Route(
            "/utilisateur/edition-mot-de-passe/{id}",
            name: "app_user_password",
            methods: ["GET", "POST"]
        )
    ]
    public function editPassword(
        User $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher
    ): Response {

        if (!$this->getUser()) {
            return $this->redirectToRoute("app_login");
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute("app_home");
        }

        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $hasher->isPasswordValid(
                    $user,
                    $form->getData()->getPlainPassword()
                )
            ) {
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setPlainPassword($form->get("newPassword")->getData());

                $this->addFlash(
                    "success",
                    "Le mot de passe a bien été modifié"
                );
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute("app_login");
            } else {
                $this->addFlash("warning", "Le mot de passe est incorrect");
            }
        }
        return $this->render("user/edit_password.html.twig", [
            "form" => $form->createView(),
        ]);
    }
    #[
        Route(
            "/utilisateur/mon-compte/{id}",
            name: "app_account",
            methods: ["GET", "POST"]
        )
    ]
    // #[IsGranted('ROLE_USER')]
    public function account(
        User $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute("app_login");
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute("app_home");
        }

        return $this->render("user/account_user.html.twig");
    }
    #[Route("/utilisateur/suppression/{id}", name: "app_user_delete", methods: ['GET'])]
    // #[IsGranted('ROLE_ADMIN')]
    public function deleteUser(EntityManagerInterface $manager, User $user): Response
    {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('app_home');
    }
}
