<?php

namespace App\Form;

use App\Entity\WebConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class WebConfigEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'colorCode',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Өнгө тохируулах',
                    'choices' =>
                        array(
                            'Улаан' => '#CD5C5C',
                            'ногоон' => '#48C9B0 ',
                            'хөх' => '#3498DB'
                        ),
                    'multiple' => false,
                    'required' => true,
                )
            )
            ->add('fontSize', TextType::class, array('attr' => array(
                "class" => "form-control",
            )))
            ->add('priority', TextType::class, array('attr' => array(
                "class" => "form-control",
            )))
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WebConfig::class,
        ]);
    }
}
