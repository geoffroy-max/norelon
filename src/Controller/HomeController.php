<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Header;
use App\Entity\Order3;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em): Response
    {
         // gestion de header depuis back office
        $products= $em->getRepository(Product::class)->findByIsBest(1);
        $headers= $em->getRepository(Header::class)->findAll();
        return $this->render('home/index.html.twig', [
            'products'=> $products,
            'headers'=>$headers
        ]);
    }
}
