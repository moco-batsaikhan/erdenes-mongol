<?php

namespace App\Form;

use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeChartEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('enDescription', TextType::class, array(
                'label' => 'График тайлбар(Англи)',
                'attr' => array(
                    "class" => "form-control",
                )
            )
            )
            ->add('mnDescription', TextType::class, array(
                'label' => 'График тайлбар(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                )
            )
            )
            ->add('cnDescription', TextType::class, array(
                'label' => 'График тайлбар(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                )
            )
            )

            ->add(
                'graphType',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'График',
                    'choices' =>
                        array(
                            'Шугаман график' => 'LineGraph',
                            'Баганан график' => 'ColumnGraph',
                            'Pie,Donut график' => 'DonutGraph',
                            'Tree map график' => 'TreemapGraph',
                            'Метрик график' => 'CaugeGraph',
                            'Dual axes график' => 'DualAxesGraph'
                        ),
                    'multiple' => false,
                    'required' => true,
                )
            )
            ->add('file', FileType::class, [
                'label' => 'Excel File (XLSX)',
                'required' => true,
                'mapped' => false,
            ])

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
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
