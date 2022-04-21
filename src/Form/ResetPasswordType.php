<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('new_password',RepeatedType::class, ['type'=>PasswordType::class, 'invalid_message'=>'le mdp de la confirmation 
            doivent etre identique', 'required'=>true, 'first_options'=>['label'=>'votre nouveau mdp','attr'=>['placeholder'=>'merci de saisir vtre  nouveau mdp']],
        'second_options'=>['label'=>'comfirme vtre nouveau mdp','attr'=>['placeholder'=>'merci de confirmé votre nouveau mdp']]])
        ->add('submit', SubmitType::class,['label'=>"Mettre à jour",
            'attr'=>['class'=>'btn-block btn-info']])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
