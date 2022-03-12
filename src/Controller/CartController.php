<?php

namespace App\Controller;

use App\Classe\Cart;
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
    public function index(Cart $cart): Response
    {

        return $this->render('cart/index.html.twig',[
            'cart'=> $cart->getfull(),

        ]);

    }

    /**
     * cette fonction premet d'ajouter le produit dans le panier
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, Cart $cart)
    {
        $cart->add($id);
        return $this->redirectToRoute('cart_index');


    }

    /**
     * cette fonction permet de diminuer un produit parmi plusieurs produits dans le panier
     * @Route("/decrease/{id}", name="cart_remove") decrease
     */
    public function decrease($id ,Cart $cart){
        $cart->decrease($id);

        return $this->redirectToRoute('cart_index');
    }
    /**
     * cette fonction permet de supprimer un  panier
     * @Route("/delete/{id}", name="cart_delete")
     */
    public function delete(Product $product, Cart $cart)
{                 $cart->delete($product);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * cette fonction permet de supprimer (retirer) toute la session de  panier
     * @Route("/delete", name="cart_delete_all")
     */
    public function remove( Cart $cart)
    {
          $cart->remove();

        return $this->redirectToRoute('cart_index');
    }
}
