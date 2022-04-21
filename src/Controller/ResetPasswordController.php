<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    /**
     * cette fonction permet de réinitialiser le mot de passe
     * @Route("/mot-de-pass-oublie", name="reset_password")
     */
    public function index(Request $request,EntityManagerInterface $em): Response
    {
        // si l'utilisateur est connecté on ne modifie pas le mdp
        // on se redirige vers la page home
        if($this->getUser()){
            return $this->redirectToRoute('home');
        }

        // on  verifier si l'email a été envoyé via  form en recupere la request
        // et ensuite on verifier si l'email existe dans la bd de donnée
        if ($request->get('email')){
            //dd($request->get('email'));
            $user= $em->getRepository(User::class)->findOneByEmail($request->get('email'));
            //dd($user);

            if ($user){
               // 1:si l'user existe on enregistre reset_password dns la bd
                $resetPassword= new ResetPassword();
                //$date= new \DateTime();
                // revenir apres concernant l'affichage de la date exacte
                $resetPassword->setUser($user);
                $resetPassword->setCreatedAt(new \DateTime());
                $resetPassword->setToken(uniqid());
                $em->persist($resetPassword);
                $em->flush();

                // 2: on envoi l'email à l'user avec un lien en lui permettant de mettre à jour ton mdp
                $url= $this->generateUrl('update-mdp',[
                    'token'=>$resetPassword->getToken()
                ]);
                $mail= new Mail();
                $content=  "bonjour <br/>" .$user->getFirstname().' '.$user->getlastname(). "<br/> Vous avez demandé à réinitialiser votre mdp. <br/><br/> ";
                $content .="Merci de  vouloir cliquer sur le lien suivant <a href='".$url."'>pour mettre à jour votre mot de passe</a>. ";
                $mail->send($user->getEmail(), $user->getFirstname().''.$user->getlastname(),'réinitialiser votre mot de passe sur le boutique de geoffroy',$content);

                $this->addFlash('notice',"vous allez recevoir un lien pour vs permettre de reinitialiser le mdp");
            }else{
                $this->addFlash('notice', "votre email est inconnu");
            }


        }

        return $this->render('reset_password/index.html.twig', [

        ]);
    }

    /**
     * cette fonction permet de modifier le mot de passe
     * @param $token
     * @Route("modifier-le mot-de passe/{token}", name="update-mdp")
     */
    public function update($token,EntityManagerInterface $em,Request $request,UserPasswordHasherInterface $encoder){

      $resetPassword= $em->getRepository(ResetPassword::class)->findOneByToken($token);
      //dd($resetPassword);
        // si le token est different on se rédirige vers réinitialisé le mdp
        if (!$resetPassword){
           return $this->redirectToRoute('reset_password');
        }
        // on recupere la date qui été demandé pour réinitialiser le mdp
        //  ensuite on verifier si la date actuelle est > supposons de 3h à la date qui a été demande
        //pr réinitialiser le mdp :si c le cas le token a expiré.
        // dans mon cas depassé 3h le token est expiré

        $resetDateMdp= $resetPassword->getCreatedAt()->modify('3hours');

        $now= new \DateTime();

        if ($now>$resetDateMdp){
            $this->addFlash('notice',"votre demande de mdp à expiré: Merci de renouveller");
            return $this->redirectToRoute('reset_password');
        }
        // affiche le form pr creer l mdp et confirmé le mdp
            $form= $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            // recuperer le nouveau mdp
           $new_pwd= $form->get('new_password')->getData();
           // encoder le nouveau mdp
          $password= $encoder->hashPassword($resetPassword->getUser(),$new_pwd);
          // definir le mdp dans la table user
            $resetPassword->getUser()->setPassword($password);
            //flush dns la bd
            $em->flush();
            //redirection sur la page de login
            $this->addFlash('notice',"votre mot de passe à bien été mis à jour");
            return $this->redirectToRoute('app_login');


        }

        //dump($resetDateMdp);
        //dd($resetPassword);

        return $this->render('reset_password/uplated.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
