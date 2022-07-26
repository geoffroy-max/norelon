<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Commentaire;
use App\Entity\Header;
use App\Entity\Order;
use App\Entity\Order3;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Boutique Française');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
         yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Product', 'fas fa-tag', Product::class);
        yield MenuItem::linkToCrud('Carrier', 'fas fa-truck', Carrier::class);
        //yield MenuItem::linkToCrud('Order', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Order3', 'fas fa-shopping-cart', Order3::class);
        yield MenuItem::linkToCrud('Header', 'fas fa-desktop', Header::class);
        yield MenuItem::linkToCrud('Commentaire', 'fas fa-comments', Commentaire::class);
    }
}
