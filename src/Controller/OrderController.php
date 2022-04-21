<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * cette fonction permet de passer une commande  et faire un recap sur la commande
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart, Request $request)
    {
        //si l user a dja une adresse il continue pour psser la commande au cas contraire
        // il doit se rediriger sur une autre page pr ajouter ue adresse

        $cart->getfull();

        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('add_adress');
        }
        $form = $this->createForm(OrderType::class);

        return $this->render('order/index.html.twig', [
                'form' => $form->createView(),
                'cart' => $cart->getfull()
            ]
        );
    }



    /**
     * @Route("/commande/recapitulatif", name="order_add", methods={"POST"})
     */
    public function add(Cart $cart, Request $request)
    {

        // $total += $product->getPrice() * $quantite;

        $cart->getfull();

        $date = new \DateTime();
        $form = $this->createForm(OrderType::class);


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

            // Enregistrer ma commande Order()
            $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);


            $this->entityManager->persist($order);

            // Enregistrer mes produits OrderDetails()
            foreach ($cart->getFull() as $product) {
                $orderDetails = new OrderDetail();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['produit']->getName());
                $orderDetails->setQuantity($product['quantite']);
                $orderDetails->setPrice($product['produit']->getPrice());
                $orderDetails->setTotal($product['produit']->getPrice() * $product['quantite']);
                $this->entityManager->persist($orderDetails);

                //dd($order);
            }

            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery_content' => $delivery_content,
                'reference' => $order->getReference()
            ]);
        }

        return $this->redirectToRoute('cart');
    }
}
