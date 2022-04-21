<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Order3;
use App\Entity\OrderDetail;
use App\Entity\OrderDetail3;
use App\Entity\User;
use App\Form\Order3Type;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Order3Controller extends AbstractController
{
        private $entityManager;

        public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

        /**
         * cette fonction permet de passer une commande  et faire un recap sur la commande
         * @Route("/commande", name="order3")
         */
        public function index(Cart $cart, Request $request)
    {
        //si l user a dja une adresse il continue pour psser la commande au cas contraire
        // il doit se rediriger sur une autre page pr ajouter ue adresse

        $cart->getfull();

        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('add_adress');
        }
        $form = $this->createForm(Order3Type::class);

        return $this->render('order3/index.html.twig', [
                'form' => $form->createView(),
                'cart' => $cart->getfull()
            ]
        );
    }

        /**
         * @Route("/commande/recapitulatif", name="order3_add", methods={"POST"})
         */
        public function add(Cart $cart, Request $request)
    {

        // $total += $product->getPrice() * $quantite;

        $cart->getfull();

        $date = new \DateTime();
        $form = $this->createForm(Order3Type::class);


        // $form = $this->createForm(OrderType::class, null, [
        // 'user' => $this->getUser()
        //]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $carriers = $form->get('carrier')->getData();

            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstName().' '.$delivery->getLastName();
            $delivery_content .= '<br/>'.$delivery->getPhone();

            if ($delivery->getCompany()) {
                $delivery_content .= '<br/>'.$delivery->getCompany();
            }

            $delivery_content .= '<br/>'.$delivery->getAddress();
            $delivery_content .= '<br/>'.$delivery->getPostal().' '.$delivery->getCity();
            $delivery_content .= '<br/>'.$delivery->getCountry();

            // Enregistrer ma commande Order3()
            $order3 = new Order3();

            $reference = $date->format('dmY').'-'.uniqid();
            $order3->setReference($reference);
            $order3->setUser($this->getUser());
            $order3->setCreatedAt($date);
            $order3->setCarrierName($carriers->getName());
            $order3->setCarrierPrice($carriers->getPrice());
            $order3->setDelivery($delivery_content);
            $order3->setState(0);


            //dd($order3);
            $this->entityManager->persist($order3);

            // Enregistrer mes produits OrderDetails()
            foreach ($cart->getFull() as $product) {
                $orderDetails3 = new OrderDetail3();
                $orderDetails3->setOrder3($order3);
                $orderDetails3->setProduct($product['produit']->getName());
                $orderDetails3->setQuantity($product['quantite']);
                $orderDetails3->setPrice($product['produit']->getPrice());
                $orderDetails3->setTotal($product['produit']->getPrice() * $product['quantite']);

                $this->entityManager->persist($orderDetails3);

                //dd($order3);
            }

            $this->entityManager->flush();

            return $this->render('order3/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery_content' => $delivery_content,
                'reference' => $order3->getReference()
            ]);
        }

        return $this->redirectToRoute('cart');
    }




}
