<?php

namespace App\Controller;

use App\Classe\Search;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * cette fonction permet d'afficher tous les produits
     * @Route("/nos-produits", name="products")
     */
    public function index(ProductRepository $repository, Request $request): Response

    {
        $Search= new Search();
        $form= $this->createForm(SearchType::class, $Search);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $Search = $form->getData();
            $products = $repository->findWithSearch($Search);
        }else{
            $products= $repository->findAll();
        }
        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form'=>$form->createView()
        ]);
    }

    /**
     * cette fonction permet d'afficher un produit
     * @Route ("/produit/{slug}", name="product")
     */
    public function show($slug, EntityManagerInterface $manager, ProductRepository $repository){
        $product= $repository->findOneBySlug($slug);
        return $this->render('product/show.html.twig',[
            'product'=>$product
        ]);
    }
}
