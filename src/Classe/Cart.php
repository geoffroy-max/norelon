<?php

namespace App\Classe;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

    private $session;
    private $repository;

    public function __construct(SessionInterface $session, ProductRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
    }

    /**
     * @var
     * cette fonction permet de gerer la session de panier
     */
    public function getfull()
    {

        $cart = $this->session->get('panier', []);
        $datapanier = [];
        $total = 0;
        foreach ($cart as $id => $quantite) {
            $product = $this->repository->find($id);
            $datapanier[] = [
                'produit' => $product,
                'quantite' => $quantite
            ];

        }
        return $datapanier;
    }

    /**
     * cette fonction premet d'ajouter le produit dans le panier
     */
    public function add($id)
    {
        $panier = $this->session->get('panier', []);
        // en utilisant le product ça ns permet de ne pas mettre le num du produit qui n'existe pas
        // $id = $product->getId();
        // $id = $id->getId();
        //on ajoute un produit dans notre panier
        //$cart[$id] = 1;
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        //on sauvegarde le panier dans la session
        $this->session->set('panier', $panier);


    }

    /**
     * cette fonction permet de diminuer un produit  dans le panier
     * decrease
     */
    public function decrease($id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }
        // on sauvegarde dans la session et on retoune la session
        return $this->session->set('panier', $panier);
    }
    /**
     * cette fonction permet de supprimer  un  panier
     */
    public function delete( Product $product)
    {
        $panier= $this->session->get('panier',[]);
        $id= $product->getId();
        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        // on sauvegarde dans la session:ajoute le produit dans le panier

        return  $this->session->set('panier', $panier);
    }
    /**
     * cette fonction permet de supprimer toute la session de  panier

     */
        public function remove()
    {


        return $this->session->remove('panier');
    }


}
