<?php

namespace App\Form;

use App\Entity\WebConfig;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;


class WebConfigEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('backgroundColor',  TextType::class, array(
                'label' => 'Цэс арын өнгө',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'required' => false,
            ))
            ->add('colorCode',  TextType::class, array(
                'label' => 'Цэс текстийн өнгө',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'empty_data' => '',
                'required' => false,
            ))
            ->add('topbarBackgroundColor',  TextType::class, array(
                'label' => 'Хэл сонгох цэс арын өнгө',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'required' => false,
            ))
            ->add('langTextColor',  TextType::class, array(
                'label' => 'Хэл сонгох цэс текстийн өнгө',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'empty_data' => '',
                'required' => false,
            ))
            ->add('mnSloganText',  TextType::class, array(
                'label' => 'Уриа үг(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'empty_data' => '',
                'required' => false,
            ))
            ->add('enSloganText',  TextType::class, array(
                'label' => 'Уриа үг(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'empty_data' => '',
                'required' => false,
            ))
            ->add('cnSloganText',  TextType::class, array(
                'label' => 'Уриа үг(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'empty_data' => '',
                'required' => false,
            ))
            ->add('transparentImageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Ил тод хэсгийн зураг, тохирох хэмжээ(1440*410px)',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => false,
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('sloganImageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Уриа үг хэсгийн зураг, тохирох хэмжээ(1440*360px)',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => false,
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('coverImageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Динамик хуудаснуудын header зураг',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => false,
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])

            ->add('contactImageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Холбоо барих хэсгийн зураг',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => false,
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])

            ->add('mnFooterText', CKEditorType::class, array(
                'label' => 'footer танилцуулга(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('enFooterText', CKEditorType::class, array(
                'label' => 'footer танилцуулга(Англи)',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('cnFooterText', CKEditorType::class, array(
                'label' => 'footer танилцуулга(Хятад)',
                'attr' => array(
                    "class" => "form-control",
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
            'data_class' => WebConfig::class,
        ]);
    }
}
