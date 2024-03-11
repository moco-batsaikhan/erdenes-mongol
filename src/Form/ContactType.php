<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('mnAddress', TextType::class, array(
            'label' => 'Хаяг(Монгол)',
            'attr' => array(
                "class" => "form-control",
            )
        ))
        ->add('enAddress', TextType::class, array(
            'label' => 'Хаяг(Англи)',
            'attr' => array(
                "class" => "form-control",
            )
        ))
        ->add('cnAddress', TextType::class, array(
            'label' => 'Хаяг(Хятад)',
            'attr' => array(
                "class" => "form-control",
            )
        ))
        ->add('phone', TextType::class, array(
            'label' => 'Утас',
            'attr' => array(
                "class" => "form-control",
            )
        ))
        ->add('email', TextType::class, array(
            'label' => 'Email',
            'attr' => array(
                "class" => "form-control",
            )
        ))
        ->add('save', SubmitType::class, array(
            'label' => 'Хадгалах',
            'attr' => array(
                "class" => "btn btn-primary btn-sm"
            )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
