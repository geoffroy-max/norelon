<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     *
     * @Route("/compte", name="account")
     */
    public function index(EntityManagerInterface $em): Response
    {


        return $this->render('account/index.html.twig'

        );
    }
}
