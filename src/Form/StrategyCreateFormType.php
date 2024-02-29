<?php

namespace App\Form;

use App\Entity\Strategy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class StrategyCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnTitle', TextType::class, [
                'label' => 'гарчиг(Монгол)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'гарчиг оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('enTitle', TextType::class, [
                'label' => 'гарчиг(Англи)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'гарчиг оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('cnTitle', TextType::class, [
                'label' => 'гарчиг(Хятад)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'гарчиг оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('mnVision', TextAreaType::class, [
                'label' => 'алсын хараа(Монгол)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'алсын хараа оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('enVision', TextAreaType::class, [
                'label' => 'алсын хараа(Англи)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'алсын хараа оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('cnVision', TextAreaType::class, [
                'label' => 'алсын хараа(Хятад)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'алсын хараа оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('mnPurpose', TextAreaType::class, [
                'label' => 'зорилго(Монгол)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'зорилго оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('enPurpose', TextAreaType::class, [
                'label' => 'зорилго(Англи)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'зорилго оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('cnPurpose', TextAreaType::class, [
                'label' => 'зорилго(Хятад)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'зорилго оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('mnMission', TextAreaType::class, [
                'label' => 'эрхэм зорилго(Монгол)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'эрхэм зорилго оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('enMission', TextAreaType::class, [
                'label' => 'эрхэм зорилго(Англи)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'эрхэм зорилго оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('cnMission', TextAreaType::class, [
                'label' => 'эрхэм зорилго(Хятад)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'эрхэм зорилго оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('mnTarget', TextAreaType::class, [
                'label' => 'зорилт(Монгол)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'зорилт оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('enTarget', TextAreaType::class, [
                'label' => 'зорилт(Англи)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'зорилт оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('cnTarget', TextAreaType::class, [
                'label' => 'зорилт(Хятад)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'зорилт оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('mnResult', TextAreaType::class, [
                'label' => 'үр дүн(Монгол)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'үр дүн оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('enResult', TextAreaType::class, [
                'label' => 'үр дүн(Англи)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'үр дүн оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('cnResult', TextAreaType::class, [
                'label' => 'үр дүн(Хятад)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'үр дүн оруулна уу ...',
                ],
                'required' => false,
            ])
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
            ->add('save', SubmitType::class, [
                'label' => 'Хадгалах',
                'attr' => [
                    'class' => 'btn btn-primary btn-sm',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Strategy::class,
        ]);
    }
}
