<?php

namespace App\Form;

use App\Entity\IdentityUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdentityUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, [
                "label" => "Prénom"
            ])
            ->add('lastName', null, [
                "label" => "Nom d'usage"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IdentityUser::class,
        ]);
    }
}
