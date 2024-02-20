<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\NewsType;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubCategoryEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnName', TextType::class, array(
                'label' => 'Монгол цэс',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэс нэр оруулна уу ...",
                )
            ))
            ->add('enName', TextType::class, array(
                'label' => 'Англи цэс',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэс нэр оруулна уу ...",
                )
            ))
            ->add('cnName', TextType::class, array(
                'label' => 'Хятад цэс',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэс нэр оруулна уу ...",
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
                    'required' => false,
                )
            )
            ->add('priority', NumberType::class, array(
                'label' => 'Дарааалал',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add(
                'clickType',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control click-type-select'),
                    'label' => 'Цэсийг дарах үед',
                    'choices' =>
                    array(
                        'Сонгосон мэдээний жагсаалтуудруу үсрэх' => 'THUMBNAIL',
                        'Сонгосон мэдээрүү шууд үсрэх' => 'REDIRECT',
                        'Сонгосон линкрүү шууд үсрэх' => 'LINK',
                    ),
                    'multiple' => false,
                    'required' => true,
                )
            )
            ->add('newsTypeId', EntityType::class, [
                'label' => 'Үсрэх мэдээний төрөл сонгох',
                'class' => NewsType::class,
                'choice_label' => 'name',
                'placeholder' => '',
                'required' => false,
            ])
            ->add('newsId', EntityType::class, [
                'label' => 'Үсрэх мэдээ сонгох',
                'class' => News::class,
                'choice_label' => 'mnTitle',
                'placeholder' => '',
                'required' => false,
            ])

            ->add('redirectLink', TextType::class, array(
                'label' => 'Үсрэх линк оруулна уу',
                'required' => false,
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "линк оруулна уу ...",
                )
            ))

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);;;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubCategory::class,
        ]);
    }
}
