<?php

namespace App\Form;

use App\Entity\CompanyStructure;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('mnName', TextType::class, array(
            'label' => 'Нэр(Монгол)',
            'attr' => array(
                "class" => "form-control",
                "placeholder" => "тайлбар оруулна уу ...",
            )
        ))
        ->add('enName', TextType::class, array(
            'label' => 'Нэр(Англи)',
            'attr' => array(
                "class" => "form-control",
                "placeholder" => "тайлбар оруулна уу ...",
            )
        ))
        ->add('cnName', TextType::class, array(
            'label' => 'Нэр(Хятад)',
            'attr' => array(
                "class" => "form-control",
                "placeholder" => "тайлбар оруулна уу ...",
            )
        ))
        ->add('mnBody', CKEditorType::class, array(
            'label' => 'Агуулга(Монгол)',
            'attr' => array(
                "class" => "form-control",
            )
        ))
        ->add('cnBody', CKEditorType::class, array(
            'label' => 'Агуулга(Хятад)',
            'attr' => array(
                "class" => "form-control",
            )
        ))
        ->add('enBody', CKEditorType::class, array(
            'label' => 'Агуулга(Англи)',
            'attr' => array(
                "class" => "form-control",
            )
        ))
            ->add('phone', TextType::class, array(
                'label' => 'Утас',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('web', TextType::class, array(
                'label' => 'Веб хаяг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('mnAddress', TextType::class, array(
                'label' => 'Хаяг(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "Хаяг оруулна уу ...",
                )
            ))
            ->add('enAddress', TextType::class, array(
                'label' => 'Хаяг(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "Хаяг оруулна уу ...",
                )
            ))
            
            ->add('cnAddress', TextType::class, array(
                'label' => 'Хаяг(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "Хаяг оруулна уу ...",
                )
            ))
            ->add('iconFile', VichFileType::class, [
                'required' => false,
                'label' => 'Зураг оруулах, тохирох хэмжээ(230*100px)',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyStructure::class,
        ]);
    }
}
