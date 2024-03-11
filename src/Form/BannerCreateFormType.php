<?php

namespace App\Form;

use App\Entity\Banner;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BannerCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('mnText', TextType::class, array(
                'label' => 'Монгол тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('enText', TextType::class, array(
                'label' => 'Англи тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('cnText', TextType::class, array(
                'label' => 'Хятад тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
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
            ->add('imageFile', VichFileType::class, [
                'required' => true,
                'label' => 'Зураг оруулах',
                'allow_delete' => true,
                'error_bubbling' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('iconFile', VichFileType::class, [
                'required' => true,
                'label' => 'Logo оруулах',
                'allow_delete' => true,
                'error_bubbling' => true,
                'allow_file_upload' => true,
                'download_label' => 'Logo харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('enIconFile', VichFileType::class, [
                'required' => true,
                'label' => 'Logo(Англи) оруулах',
                'allow_delete' => true,
                'error_bubbling' => true,
                'allow_file_upload' => true,
                'download_label' => 'Logo харах',
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
            'data_class' => Banner::class,
        ]);
    }
}
