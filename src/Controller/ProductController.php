<?php

namespace App\Controller;

use App\Classe\Search;
use App\Repository\CommentaireRepository;
use App\Service\CommentaireService;
use App\Entity\Commentaire;
use App\Entity\Order3;
use App\Entity\Product;
use App\Form\CommentaireType;
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
    public function show($slug, EntityManagerInterface $manager, ProductRepository $repository,
                         Request $request, CommentaireService $service,CommentaireRepository $commentaire1,Product $product){

        $commentaire= new Commentaire();
        $commentaires= $commentaire1->findCommentaire($product);


        $product= $manager->getRepository(Product::class)->findOneBySlug($slug);
        $products= $manager->getRepository(Product::class)->findByIsBest(1);

        $form= $this->createForm(CommentaireType::class,$commentaire);

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $commentaires= $form->getData();
            //dd($commentaire);
            $service->persistComentaire($commentaire,$product);
            return $this->redirectToRoute('product',['slug'=>$product->getslug()]);
        }


        return $this->render('product/show.html.twig',[
            'product'=>$product,
            'products'=>$products,
            'form'=>$form->createView(),
            'commentaires'=>$commentaires


        ]);
    }
}
