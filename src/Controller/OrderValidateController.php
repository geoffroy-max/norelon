<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\success;
use App\Entity\Order;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{

    /**
     * @Route("/success-url", name="success_url")
     */
    public function successUrl(Cart $cart,EntityManagerInterface $em,$reference): Response
    {

        $cart->remove();
       $order= $em->getRepository(Order::class)->findOneByReference($reference);

       // modifiant le status de isPaid en mettant 1
       if(!$order->isPaid()){
           $order->isPaid(1);
           $em->flush();
       }

            return $this->render('validate/success.html.twig', [
             // 'order'=>$order
            ]);

    }

    /**
     * @Route("/cancel-url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
   // envoyer un email à notre client pour lui confirmé sa commande
        return $this->render('validate/cancel.html.twig',[]);
    }
}
