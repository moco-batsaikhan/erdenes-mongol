<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevelopmentEnData extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Month', TextType::class, [
                'label' => 'сар',
            ])
            ->add('description', TextType::class, [
                'label' => 'Англи тайлбар',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {}
}
