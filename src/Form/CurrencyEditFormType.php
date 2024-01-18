<?php

namespace App\Form;

use App\Entity\Currency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('base')
            ->add('rates')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('CurrencyDate')
            ->add('createdUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Currency::class,
        ]);
    }
}
