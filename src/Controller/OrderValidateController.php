<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Classe\success;
use App\Entity\Order;
use App\Entity\Order3;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{

    /**
     * @Route("/commande/success/{stripeSessionId}", name="success_url/")
     */
    public function successUrl(Cart $cart, EntityManagerInterface $em,$stripeSessionId): Response
    {

        $cart->remove();
        //$mail= new Mail();

      $order3 = $em->getRepository(Order3::class)->findOneByStripeSessionId($stripeSessionId);

        // verifier si la commande est payée ou non au cas ou la cmd n'est pas payée en vider lasession
       if ($order3->getState()== 0) {
           //vider la session
           $cart->remove();
           // modifiant le status de isPaid en mettant 1
        $order3->setState(1);
            $em->flush();
            }

            // envoyer un email à notre client pour lui confirmé sa commande
        $mail= new Mail();
        //$order3= new Order3();
        $content= "Bonjour".$order3->getUser()->getFirstname()."<br/> Merci pour votre commande";
        $mail->send($order3->getUser()->getEmail(),$order3->getUser()->getFirstname(),'bienvenue sur la boutique francaise de geoffroy', $content);
            return $this->render('validate/success.html.twig', [
                'order3'=>$order3
            ]);

        }

        /**
         * @Route("/commande/erreur", name="cancel_url")
         */
        public function cancelUrl(): Response
        {

            return $this->render('validate/cancel.html.twig', []);
        }
    }
