<?php

namespace App\Classe;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class success
{


    private $repo;


    public function __construct( OrderRepository $repo)
    {

        $this->repository = $repo;
    }

    /**
     * @var
     * cette fonction permet de gerer la session de panier
     */
    public function getSuccess($orderId)
    {
        $order = $this->repo->findOneByOrderId(['order_id' => $orderId]);

       // (!$order->getIsPaid()){
       // if (!$order->getIsPaid()){
            // modifiant le status de notre ispaid en mettant 1
           //  $order->setIsPaid(1);
       // }

        return $order;
// modifiant le status de notre ispaid en mettant 1
            // $order->setIsPaid();
        }




}
