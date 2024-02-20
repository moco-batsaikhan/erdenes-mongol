<?php

namespace App\Form;

use App\Entity\MainCategory;
use App\Entity\News;
use App\Entity\NewsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainCategoryEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnName', TextType::class, array(
                'label' => 'Цэс нэр(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэс нэр оруулна уу ...",
                )
            ))
            ->add('enName', TextType::class, array(
                'label' => 'Цэс нэр(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэс нэр оруулна уу ...",
                )
            ))
            ->add('cnName', TextType::class, array(
                'label' => 'Цэс нэр(Хятад)',
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
            ->add(
                'type',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Байршил',
                    'choices' =>
                    array(
                        'Дээрх цэс' => 'HEADER',
                        'Хажуу цэс' => 'SIDEBAR',
                        'Доорх цэс' => 'FOOTER',
                        'Бүх цэс' => 'ALL'
                    ),
                    'multiple' => false,
                    'required' => true,
                )
            )
            ->add('priority', NumberType::class, array(
                'label' => 'Өрөгдөх дарааалал',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add(
                'clickType',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control click-type-select'),
                    'label' => 'Дарах үед',
                    'choices' =>
                    array(
                        '' => '',
                        'Сонгосон жагсаалтуудруу үсрэх' => 'THUMBNAIL',
                        'Сонгосон мэдээрүү үсрэх' => 'REDIRECT',
                        'Сонгосон линкрүү үсрэх' => 'LINK',
                        'Уналттай цэс' => 'DROPDOWN',
                    ),
                    'multiple' => false,
                    'required' => true,
                )
            )
            ->add('newsType', EntityType::class, [
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
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MainCategory::class,
        ]);
    }
}
