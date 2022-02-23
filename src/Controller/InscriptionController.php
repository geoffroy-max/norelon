<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{

    private $manager;

    public function __construct( EntityManagerInterface $manager){
        $this->manager= $manager;
}
    /**
     * permet de creer un form d'inscription
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form= $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $user= $form->getData();
            //$password= $user->getpassword();
            $password= $encoder->hashPassword($user,$user->getpassword());
            $user->setPassword($password);
            $this->manager->persist($user);
             $this->manager->flush();

        }
        return $this->render('inscription/index.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
