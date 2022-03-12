<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends AbstractController
{
    /**
     * cette fonction permet de creer une session stripe
     * @Route("/commande/create-checkout-session/{reference}", name="stripe_create_session")
     */
    public function index(Cart $cart,$reference,EntityManagerInterface $em)
    {
        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        // trouver un seul enregistremnt par sa reference
        //foreach ($cart->getFull() as $product): ce foreach est utilisé quand on boucle sur un panier
        // erreur je dois revnir

        $order = $em->getRepository(Order::class)->findOneByReference($reference);
        if (!$order){
            $this->redirect('order');
        }

     //bouclé sur nos données en provenance de la bd de orderdetail

        foreach($order->getOrderDetails()->getValues() as $product) {
            $product_objet = $em->getRepository(Product::class)->findOneByName($product->getProduct());
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN . "/product/images/" . $product_objet->getImageFile()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $order->getCarrierPrice(),
                    'product_data' => [
                        'name' => $order->getCarrierName(),
                        'images' => [$YOUR_DOMAIN],
                    ],
                ],
                'quantity' => 1,
            ];
         //dd(  $product_for_stripe);

        // instance le stripe
        Stripe::setApiKey('sk_test_51KYfwiK34I5Ruk8iKmZanpw0AmkgoNl7si6lMoBfiC6tWwuk7zQQtqtMKiNWO2XEaCmvGyCUWiZrWRPIId30DSgN00y7uZmUq1');
          // creons une session stripe qui  permet à votre client de voir la page de paiement hebergée par stripe

        $checkout_session = Session::create([
            'customer_email'=>$this->getUser()->getEmail(),
            'line_items' => [
                $product_for_stripe
            ],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            //  raison
            // pr laquelle j'ajoute un 3 em parametres qui est CKECKOUT_SESSION_ID
            // ensuite on doit ajouter CKECKOUT_SESSION_ID dns la bd  via order
          // 'success_url' => $YOUR_DOMAIN . '/success.html',
            //'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            //{CKECKOUT_SESSION_URL}

             //'success_url' => $YOUR_DOMAIN . '/order/success?session_id={CHECKOUT_SESSION_ID}',
            //'cancel_url' => $YOUR_DOMAIN . '/order/erreur?session_id={CHECKOUT_SESSION_ID}',

            'success_url' => $this->generateUrl('success_url',[],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url',[],UrlGeneratorInterface::ABSOLUTE_URL),



               // 'success_url' => "http://yoursite.com/order/success",
               // 'success_url' => "http://yoursite.com/order/success?session_id={CHECKOUT_SESSION_ID}",
                // other options...,




        ]);
      //$order->setStripeSessionId($checkout_session->url);


        //checkout session va generer un id ou une url de session pour stripe
        return $this->redirect($checkout_session->url,303);

    }


}
