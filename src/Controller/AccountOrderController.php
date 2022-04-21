<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Order1;
use App\Entity\Order3;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class AccountOrderController extends AbstractController
{
    /**
     * cette fonction permet de gerer les commandes
     * @Route("/compte/order", name="account_order")
     */
    public function index(EntityManagerInterface $em): Response
    {

        $orders3= $em->getRepository(Order3::class)->findSuccessOrder($this->getUser());

        return $this->render('account/order.html.twig', [
           'orders3' => $orders3

        ]);
    }

    /**
     * cette fonction permet d'afficher  les commandes
     * @Route("/compte/order/{reference}", name="show_order")
     */
    public function show(EntityManagerInterface $em,$reference): Response
    {

        $order3= $em->getRepository(Order3::class)->findOneByReference($reference);

        return $this->render('account/show.html.twig', [
            'order3' => $order3

        ]);
    }


}
