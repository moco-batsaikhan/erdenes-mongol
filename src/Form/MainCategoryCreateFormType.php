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

class MainCategoryCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnName', TextType::class, array(
                'label' => 'Цэс нэр(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэсний нэр оруулна уу ...",
                )
            ))
            ->add('enName', TextType::class, array(
                'label' => 'Цэс нэр(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэсний нэр оруулна уу ...",
                )
            ))
            ->add('cnName', TextType::class, array(
                'label' => 'Цэс нэр(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "цэсний нэр оруулна уу ...",
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
                'label' => 'Цэс өрөгдөх дарааалал',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add(
                'type',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Цэсний байршил',
                    'choices' =>
                        array(
                            'Header байршилд' => 'HEADER',
//                        'Хажуу цэс' => 'SIDEBAR',
                            'Footer байршилд' => 'FOOTER',
                            'Бүх байршилд' => 'ALL'
                        ),
                    'multiple' => false,
                    'required' => true,
                )
            )
            ->add(
                'clickType',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control click-type-select'),
                    'label' => 'Action хийх үед /цэс дээр дарахад/',
                    'choices' =>
                        array(
                            '' => '',
                            'Жагсаалт харуулах' => 'THUMBNAIL',
                            'Мэдээ харуулах' => 'REDIRECT',
                            'Статик хуудас' => 'LINK',
                            'Доорх цэс харагдах' => 'DROPDOWN',
                        ),
                    'multiple' => false,
                    'required' => true,
                )
            )
            ->add('newsType', EntityType::class, [
                'label' => 'Жагсаалт сонгох',
                'attr' => array('class' => 'form-control click-type-select'),
                'class' => NewsType::class,
                'choice_label' => 'name',
                'placeholder' => '',
                'required' => false,
            ])
            ->add('newsId', EntityType::class, [
                'label' => 'Мэдээ сонгох',
                'attr' => array('class' => 'form-control click-type-select'),
                'class' => News::class,
                'choice_label' => 'mnTitle',
                'placeholder' => '',
                'required' => false,
            ])
            ->add('redirectLink', TextType::class, array(
                'label' => 'Статик хуудас линк оруулах',
                'required' => false,
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "Статик хуудас линк оруулна уу ...",
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
