<?php

namespace App\Form;

use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChartDataCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'нэр',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('file', FileType::class, [
                'label' => 'Excel File (XLSX)',
                'required' => true,
                'mapped' => false,
            ])

            ->add('priority', NumberType::class, array(
                'label' => 'Дарааалал',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('News', EntityType::class, [
                'label' => 'Аль мэдээнд хамаарахыг сонгоно уу!',
                'class' => 'App\Entity\News',
                'choice_label' => 'mnTitle',
                'attr' => array(
                    "class" => "form-control ",
                    'data-live-search'=>"true"
                )
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
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
