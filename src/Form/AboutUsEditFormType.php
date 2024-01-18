<?php

namespace App\Form;

use App\Entity\AboutUs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AboutUsEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnPurpose', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('enPurpose', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('cnPurpose', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('mnVision', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('enVision', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('mnSlogan', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('enSlogan', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('cnSlogan', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('mnSlogan', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('enSlogan', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('cnSlogan', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('imageFile', VichFileType::class, [
                'required' => true,
                'label' => 'Зураг оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('mnPrinciples', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('enPrinciples', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('cnPrinciples', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AboutUs::class,
        ]);
    }
}
