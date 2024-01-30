<?php

namespace App\Form;

use App\Entity\NewsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsTypeCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Хэрэглэгчийн нэр',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "мэдээний төрлийн нэр оруулна уу ...",
                )
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Хадгалах',
                'attr' => array(
                    "class" => "btn btn-primary btn-sm"
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsType::class,
        ]);
    }
}
