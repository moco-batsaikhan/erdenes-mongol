<?php

namespace App\Form;

use App\Entity\JobAds;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JobAdsCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Гарчиг(Монгол)',
                'required' => false,

                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('enTitle', TextType::class, array(
                'label' => 'Гарчиг(Англи)',
                'required' => false,

                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('cnTitle', TextType::class, array(
                'label' => 'Гарчиг(Хятад)',
                'required' => false,

                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('profession', TextType::class, array(
                'label' => 'Ажил(Монгол)',
                'required' => false,

                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('enProfession', TextType::class, array(
                'label' => 'Ажил(Англи)',
                'required' => false,

                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('cnProfession', TextType::class, array(
                'label' => 'Ажил(Хятад)',
                'required' => false,

                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('body', CKEditorType::class, array(
                'label' => 'Агуулга(Монгол)',
                'required' => false,

                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('enBody', CKEditorType::class, array(
                'label' => 'Агуулга(Англи)',
                'required' => false,

                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('cnBody', CKEditorType::class, array(
                'label' => 'Агуулга(Хятад)',
                'required' => false,
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('applicationDeadline', DateType::class, array(
                'label' => 'Дуусах огноо',
                'required' => true,
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
                    'required' => true,
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
            'data_class' => JobAds::class,
        ]);
    }
}
