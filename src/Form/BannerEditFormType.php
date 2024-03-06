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
                'label' => 'Нүүр зургийн тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "нүүр зургийн тайлбар оруулна уу ...",
                )

            ))
            ->add('enText', TextType::class, array(
                'label' => 'Нүүр зургийн тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "нүүр зургийн тайлбар оруулна уу ...",
                )

            ))
            ->add('cnText', TextType::class, array(
                'label' => 'Нүүр зургийн тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "нүүр зургийн тайлбар оруулна уу ...",
                )
            ))

            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Зураг оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('iconFile', VichFileType::class, [
                'required' => false,
                'label' => 'Logo оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Logo харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('enIconFile', VichFileType::class, [
                'required' => false,
                'label' => 'Logo(Англи) оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Logo харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
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
                    'required' => true,
                )
            )

            ->add('save', SubmitType::class, array(
                'label' => 'Хадгалах',
                'attr' => array(
                    "class" => "btn btn-primary btn-sm"
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banner::class,
        ]);
    }
}
