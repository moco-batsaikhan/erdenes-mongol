<?php

namespace App\Form;

use App\Entity\Currency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\JsonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('base', NumberType::class, array(
                'label' => 'Суурь',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('rates', FileType::class, [
                'label' => 'Excel File (XLSX)',
                'required' => true,
                'mapped' => false,
            ])
            ->add('CurrencyDate', DateType::class, array(
                'label' => 'Ханшийн он сар',
                'required' => true,
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Currency::class,
        ]);
    }
}
