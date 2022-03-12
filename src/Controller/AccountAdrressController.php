<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AdressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdrressController extends AbstractController
{
    /**
     * @Route("/compte/adress", name="account_adrress")
     * cette fonction permet de gerer mes adresses
     */
    public function index(): Response
    {
        return $this->render('account/adress.html.twig'
        );
    }

    /**
     * @Route("/compte/add-une-adresse" , name="add_adress")
     * cette fonction permet d'ajouter une adresse
     */
    public function add(Request $request,EntityManagerInterface $manager, SessionInterface $session){
        $adress= new Address();

        $form= $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
          $user = $this->getUser();
          $adress->setUser($user);
          $manager->persist($adress);
          $manager->flush();
          // si j'ai le produit dans le panier je dois me redireger dans order pr psser la commande
            //  sinon vers accoun adrs

            if($session->get('panier')){
                return $this->redirectToRoute('order');
            }
          return $this->redirectToRoute('account_adrress');


        }

        return $this->render('account/form.index.twig', [
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/compte/modifier-une-adresse/{id}" , name="edit_adress")
     * cette fonction permet de modifier l'adresse une adresse
     */
    public function edit(Request $request,EntityManagerInterface $manager,AddressRepository $repository,$id){

// si l'adresse est differente ou l'user de l'adresse est different de l'user qui est connecté on fait un retour account adress
        $adress= $repository->findOneById($id);
        if (!$adress || $adress->getUser()!= $this->getUser()){

            return $this->redirectToRoute('account_adrress');
        }

        $form= $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){

            $manager->flush();
            return $this->redirectToRoute('account_adrress');


        }

        return $this->render('account/form.index.twig', [
            'form'=>$form->createView()
        ]);

    }
    /**
     * @Route("/compte/supprimer-une-adresse/{id}" , name="delete_adress")
     * cette fonction permet de supprimer une adresse
     */
    public function delete(EntityManagerInterface $manager,$id, AddressRepository $repository)
    {

       // si l adress existe et l'user de l adr est bel bien l'user qui est connecté
        // dans ce cas on supprimer l'adresse

         $adress= $repository->findOneById($id);
        if ($adress && $adress->getUser() == $this->getUser()) {
            $manager->remove($adress);
            $manager->flush();
        }
        return $this->redirectToRoute('account_adrress');
    }

}
