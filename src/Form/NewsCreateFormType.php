<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\NewsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



use Symfony\Component\Form\Extension\Core\Type\DateType;

class NewsCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnTitle', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('enTitle', TextType::class, array(
                'label' => 'Англи гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('cnTitle', TextType::class, array(
                'label' => 'Хятад гарчиг',
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
            ->add(
                'isSpecial',
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
                'label' => 'Thumbnail зураг оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('bodyimageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Мэдээ унших хэсгийн зураг оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('newsType', EntityType::class, [
                'label' => 'Үсрэх мэдээний төрөл сонгох',
                'class' => NewsType::class,
                'choice_label' => 'name',
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
            'data_class' => News::class,
        ]);
    }
}
