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
use Vich\UploaderBundle\Form\Type\VichFileType;

class StrategyEditFormType extends AbstractType

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
            ->add('pdfFile', VichFileType::class, [
                'label' => 'PDF File',
                'download_label'=>false,
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
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
                'label' => 'Стратегийн зорилго(Монгол)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Стратегийн зорилго оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('enPurpose', TextAreaType::class, [
                'label' => 'Стратегийн зорилго(Англи)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Стратегийн зорилго оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('cnPurpose', TextAreaType::class, [
                'label' => 'Стратегийн зорилго(Хятад)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Стратегийн зорилго оруулна уу ...',
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
                'label' => 'үнэт зүйл(Монгол)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'үнэт зүйл оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('enTarget', TextAreaType::class, [
                'label' => 'үнэт зүйл(Англи)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'үнэт зүйл оруулна уу ...',
                ],
                'required' => false,
            ])
            ->add('cnTarget', TextAreaType::class, [
                'label' => 'үнэт зүйл(Хятад)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'үнэт зүйл оруулна уу ...',
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
                    'required' => true,
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
