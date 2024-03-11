<?php

namespace App\Form;

use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CkeditorEditFormType extends AbstractType
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
            ->add('mnDescription', CKEditorType::class, array(
                'label' => 'Агуулга Монгол',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('enDescription', CKEditorType::class, array(
                'label' => 'Агуулга Англи',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('cnDescription', CKEditorType::class, array(
                'label' => 'Агуулга Хятад',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('priority', NumberType::class, array(
                'label' => 'Дарааалал',
                'attr' => array(
                    "class" => "form-control",
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
            ->add('News', EntityType::class, [
                'label' => 'Аль мэдээнд хамаарахыг сонгоно уу!',
                'class' => 'App\Entity\News',
                'choice_label' => 'mnTitle',
                'attr' => array(
                    "class" => "form-control",
                    'data-live-search'=>"true"
                )
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);;;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
