<?php

namespace App\Controller\Admin;

use App\Entity\Ess;
use App\Entity\Blog;
use App\Entity\Image;
use App\Entity\Users;
use App\Entity\Articlespresse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin.index')]
    public function index(): Response
    {

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Moness.fr - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('structure des ess', 'fas fa-building', Ess::class);
        yield MenuItem::linkToCrud(' utilisateurs', 'fas fa-users', Users::class);
        yield MenuItem::linkToCrud(' blogs', 'fas fa-blog', Blog::class);
        yield MenuItem::linkToCrud(' articlepresse', 'fas fa-newspaper', Articlespresse::class);
        
    }
}
