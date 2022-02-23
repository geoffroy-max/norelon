<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use SessionIdInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * cette fonction premet de gerer le panier
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session,ProductRepository $repository): Response
    {
        $panier= $session->get('panier', []);
        $datapanier= [];
        $total= 0;
         foreach ($panier as $id => $quantite){
             $product= $repository->find($id);
             $datapanier[]= [
                 'produit'=>$product,
                 'quantite'=>$quantite
             ];
             $total += $product->getPrice()*$quantite;
         }
        return $this->render('cart/index.html.twig',compact("datapanier","total")
        );
    }

    /**
     * cette fonction premet d'ajouter le produit dans le panier
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add(Product $product, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        // en utilisant le product ça ns permet de ne pas mettre le num du produit qui n'existe pas
        $id = $product->getId();
        // $panier[$id]= 1 : on ajoute un produit dans notre panier
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        //on sauvegarde le panier dans la session
        $session->set('panier', $panier);

       return $this->redirectToRoute('cart_index');


    }

    /**
     * cette fonction permet de supprimer un produit parmi plusieurs produits dans le panier
     * @Route("/remove/{id}", name="cart_remove")
     */
    public function remove($id ,SessionInterface $session){
        $panier= $session->get('panier',[]);
        if(!empty($panier[$id])) {
           if ($panier[$id]>1){
               $panier[$id]--;
        }else {
               unset($panier[$id]);
           }
        }
        // on sauvegarde dans la session
        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
    }
    /**
     * cette fonction permet de supprimer un  panier
     * @Route("/delete/{id}", name="cart_delete")
     */
    public function delete(Product $product, SessionInterface $session)
{
        $panier= $session->get('panier',[]);
        $id= $product->getId();
        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        // on sauvegarde dans la session:ajoute le produit dans le panier
        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * cette fonction permet de supprimer toute la session de  panier
     * @Route("/delete", name="cart_delete_all")
     */
    public function deleteAll( SessionInterface $session)
    {
       $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }
}
