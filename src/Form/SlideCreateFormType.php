<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Content;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SlideCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Монгол тайлбар',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'тайлбар оруулна уу ...',
                ],
            ])
            ->add('priority', NumberType::class, [
                'label' => 'Дарааалал',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('News', EntityType::class, [
                'label' => 'Аль мэдээнд хамаарахыг сонгоно уу!',
                'class' => 'App\Entity\News',
                'choice_label' => 'mnTitle',
            ])
            ->add('active', ChoiceType::class, [
                'label' => 'Төлөв',
                'choices' => [
                    'Идэвхитэй' => true,
                    'Идэвхигүй' => false,
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'multiple' => false,
                'required' => false,
            ])
            ->add('file', FileType::class, [
                'label' => 'Upload Images',
                'multiple' => true,
                'mapped' => false,
            ])
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
            'data_class' => Content::class,
        ]);
    }
}
