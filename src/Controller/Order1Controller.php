<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Order1;
use App\Entity\OrderDetail;
use App\Entity\OrderDetail1;
use App\Form\Order1Type;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Order1Controller extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * cette fonction permet de passer une commande  et faire un recap sur la commande
     * @Route("/order", name="order1")
     */
    public function index(Cart $cart, Request $request)
    {
        //si l user a dja une adresse il continue pour passer la commande au cas contraire
        // il doit se rediriger sur une autre page pr ajouter ue adresse

        $cart->getfull();

        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('add_adress');
        }
        $form = $this->createForm(Order1Type::class);

        return $this->render('order1/index.html.twig', [
                'form' => $form->createView(),
                'cart' => $cart->getfull()
            ]
        );
    }



    /**
     * @Route("/order/recapitulatif", name="order1_add",methods={"POST"})
     */
         public function add(Cart $cart, Request $request)
    {

        // $total += $product->getPrice() * $quantite;

       $cart->getfull();

        $date = new \DateTime();
        $form = $this->createForm(Order1Type::class);


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

            // Enregistrer ma commande Order1()
            $order1   = new Order1();
            $reference = $date->format('dmY').'-'.uniqid();
            $order1->setReference($reference);
            $order1->setUser($this->getUser());
            $order1->setCreatedAt($date);
            $order1->setCarrierName($carriers->getName());
            $order1->setCarrierPrice($carriers->getPrice());
            $order1->setDelivery($delivery_content);
            $order1->setIsPaid(0);


            $this->entityManager->persist($order1);

            // Enregistrer mes produits OrderDetails()
            foreach ($cart->getFull() as $product) {
                $orderDetail1 = new OrderDetail1();
                $orderDetail1->setOrder1($order1);
                $orderDetail1->setProduct($product['produit']->getName());
                $orderDetail1->setQuantity($product['quantite']);
                $orderDetail1->setPrice($product['produit']->getPrice());
                $orderDetail1->setTotal($product['produit']->getPrice() * $product['quantite']);
                $this->entityManager->persist($orderDetail1);
            }

            $this->entityManager->flush();

            return $this->render('order1/index1.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery_content' => $delivery_content,
                'reference' => $order1->getReference()
            ]);
        }

        return $this->redirectToRoute('cart');
    }


}
