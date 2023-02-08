<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Programmes;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new ()
            ->setTitle('<img src="assets/img/Logo transparent.png">')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToDashboard('Programmes', 'fa fa-diamond');
        yield MenuItem::linkToCrud('Programmes', 'fa fa-diamond', Programmes::class);
        yield MenuItem::linkToCrud('Utilisateurs', "fa fa-user", User::class);
        yield MenuItem::linkToCrud('Contacts', "fa fa-address-book", Contact::class);
    }
}
