<?php

namespace App\Form;

use App\Entity\MainCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainCategoryEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnName', TextType::class, array(
                'label' => 'Монгол цэс',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэс нэр оруулна уу ...",
                )
            ))
            ->add('enName', TextType::class, array(
                'label' => 'Англи цэс',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэс нэр оруулна уу ...",
                )
            ))
            ->add('cnName', TextType::class, array(
                'label' => 'Хятад цэс',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэс нэр оруулна уу ...",
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
            ->add(
                'type',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Байршил',
                    'choices' =>
                    array(
                        'Хажуу цэс' => 'sidebar',
                        'Доорх цэс' => 'footer',
                        'Бүгд' => 'all'
                    ),
                    'multiple' => false,
                    'required' => true,
                )
            )
            ->add('priority', NumberType::class, array(
                'label' => 'Дарааалал',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('url', TextType::class, array(
                'label' => 'үсрэх url',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => " оруулна уу ...",
                )
            ))

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
