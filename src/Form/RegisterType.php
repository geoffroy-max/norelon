<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class,['label'=>'votre prénom','attr'=>['placeholder'=>'saisir votre prénom']])
            ->add('lastname',TextType::class,['label'=>'votre nom','constraints'=> new Length(['min'=>2, 'max'=>10]),'attr'=>['placeholder'=>'saisir votre nom']])
            ->add('email',TextType::class,['label'=>'votre email','attr'=>['placeholder'=>'saisir votre email']])
            ->add('password',RepeatedType::class, ['type'=>PasswordType::class, 'invalid_message'=>'le mdp de la confirmation 
            doivent etre identique', 'required'=>true, 'first_options'=>['label'=>'mdp','attr'=>['placeholder'=>'merci de saisir vtre mdp']],
                'second_options'=>['label'=>'comfirme vtre mdp','attr'=>['placeholder'=>'merci de confirmé votre mdp']]])
            ->add('submit', SubmitType::class,['label'=>"s'inscrire"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
