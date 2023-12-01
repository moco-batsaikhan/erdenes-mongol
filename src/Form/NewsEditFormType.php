<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;


class NewsEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnTitle', TextType::class, array(
                'label' => 'Монгол тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('enTitle', TextType::class, array(
                'label' => 'Англи тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('cnTitle', TextType::class, array(
                'label' => 'Хятад тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('mnHeadline', TextType::class, array(
                'label' => 'Монгол тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('enHeadline', TextType::class, array(
                'label' => 'Англи тайлбар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('cnHeadline', TextType::class, array(
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
                    'label' => 'Онцгойлох',
                    'choices' =>
                    array(
                        'Онцгой' => true,
                        'Энгийн' => false
                    ),
                    'multiple' => false,
                    'required' => false,
                )
            )
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

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
