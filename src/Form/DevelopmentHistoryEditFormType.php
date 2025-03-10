<?php

namespace App\Form;

use App\Entity\DevelopmentHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevelopmentHistoryEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year', TextType::class, array(
                'label' => 'Он',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('data', CollectionType::class, array(
                'label' => 'Жагсаалт',
                'entry_type' => Data::class,
                'entry_options' => ['label' => false, 'attr' => ["class" => "customInput"]],
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('enData', CollectionType::class, array(
                'label' => 'Жагсаалт',
                'entry_type' => DevelopmentEnData::class,
                'entry_options' => ['label' => false, 'attr' => ["class" => "customInput"]],
                'allow_add' => true,
                'allow_delete' => true,
            ))

            ->add('priority', NumberType::class, array(
                'label' => 'Дарааалал',
                'attr' => array(
                    "class" => "form-control",
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
            'data_class' => DevelopmentHistory::class,
        ]);
    }
}
