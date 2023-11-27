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
//use Symfony\Component\Form\Exception\;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BannerCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


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
            ->add('order', TextType::class, array(
                'label' => 'Дарааалал',
                'attr' => array(
                    "class" => "form-control",
                )
            ))

            ->add('url', TextType::class, array(
                'label' => 'Үсрэх url',
                'required' => false,
                'attr' => array(
                    "class" => "form-control",
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
            ->add('startDate', DateType::class, array(
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
