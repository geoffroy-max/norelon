<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commd", name="commande_ex")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $date= new \DateTime();
        $commande= new Commande();
        $ref= $date->format('dmY').'-'.uniqid();
        $commande->setName('jojo')
                 ->setReference($ref);


                  $em->persist($commande);
                  $em->flush();

        return $this->render('commande/index.html.twig', [
            ]);
    }
}
