<?php

namespace App\Form;

use App\Entity\MainCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainCategoryCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnName', TextType::class, array(
                'label' => 'Цэс нэр(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэсний нэр оруулна уу ...",
                )
            ))
            ->add('enName', TextType::class, array(
                'label' => 'Цэс нэр(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэсний нэр оруулна уу ...",
                )
            ))
            ->add('cnName', TextType::class, array(
                'label' => 'Цэс нэр(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэсний нэр оруулна уу ...",
                )
            ))
            ->add(
                'active',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Төлөв',
                    'choices' =>
                    array(
                        'Идэвхитэй' => true,
                        'Идэвхигүй' => false
                    ),
                    'multiple' => false,
                    'required' => false,
                )
            )
            ->add('priority', NumberType::class, array(
                'label' => 'Цэс өрөгдөх дарааалал',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add(
                'type',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Байршил сонгох',
                    'choices' =>
                    array(
                        'Дээрх цэс' => 'HEADER',
                        'Хажуу цэс' => 'SIDEBAR',
                        'Доорх цэс' => 'FOOTER',
                        'Бүх цэс' => 'ALL'
                    ),
                    'multiple' => false,
                    'required' => true,
                )
            )

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MainCategory::class,
        ]);
    }
}
