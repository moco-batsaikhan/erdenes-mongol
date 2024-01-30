<?php

namespace App\Form;

use App\Entity\Banner;
use App\Entity\CmsUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;


class BannerEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('mnText', TextType::class, array(
                'label' => '',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "нүүр зурнийн тайлбар оруулна уу ...",
                )

            ))
            ->add('enText', TextType::class, array(
                'label' => '',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "нүүр зурнийн тайлбар оруулна уу ...",
                )

            ))
            ->add('cnText', TextType::class, array(
                'label' => '',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "нүүр зурнийн тайлбар оруулна уу ...",
                )

            ))
            ->add('startedDate', DateType::class, array(
                'label' => 'Эхлэх огноо',
                'required' => true,
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('endDate', DateType::class, array(
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

            ->add('save', SubmitType::class, array(
                'label' => 'Хадгалах',
                'attr' => array(
                    "class" => "btn btn-primary btn-sm"
                )
            ));;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banner::class,
        ]);
    }
}
