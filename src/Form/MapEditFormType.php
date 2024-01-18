<?php

namespace App\Form;

use App\Entity\Map;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Төслийн нэр',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "нэр оруулна уу ...",
                )
            ))
            ->add('information', TextType::class, array(
                'label' => 'Төслийн тухай',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add(
                'dataType',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Төслийн төрөл',
                    'choices' =>
                    array(
                        'Төмөр' => 'IRON',
                        'Хүдэр' => 'ORE',
                        'Ган' => 'STEEL'
                    ),
                    'multiple' => false,
                    'required' => false,
                )
            )
            ->add('latitude', NumberType::class, array(
                'label' => 'Өргөрөг',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('longitude', NumberType::class, array(
                'label' => 'Уртраг',
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
            'data_class' => Map::class,
        ]);
    }
}
