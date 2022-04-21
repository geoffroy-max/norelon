<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Order1;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Order1Type extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addresses',EntityType::class,[
                'label'=>"choisisez votre adresse de livraison",
                'required'=>true,
                'multiple'=>false,
                'expanded'=>true,
                'class'=> Address::class

            ])
            ->add('carrier',EntityType::class,[
                'label'=>"choisisez votre transporteur",
                'required'=>true,
                'multiple'=>false,
                'expanded'=>true,
                'class'=> Carrier::class

            ])
            ->add('submit',SubmitType::class,[
                'label'=>"valider la commande",

                'attr'=>['class'=>'btn-block btn-success' ]
            ])
        ;
    }






    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order1::class,
        ]);
    }
}
