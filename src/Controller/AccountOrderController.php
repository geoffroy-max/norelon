<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class AccountOrderController extends AbstractController
{
    /**
     *
     * @Route("/compte/order", name="account_order")
     */
    public function index(EntityManagerInterface $em): Response
    {

        $orders= $em->getRepository(Order::class)->findSuccessOrder($this->getUser());

        dd($orders);
        return $this->render('account/order.html.twig', [

        ]);
    }
}
