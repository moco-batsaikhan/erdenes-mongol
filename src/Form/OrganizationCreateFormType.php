<?php

namespace App\Form;

use App\Entity\Organization;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnName', TextType::class, array(
                'label' => 'Монгол гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
                )
            ))
            ->add('enName', TextType::class, array(
                'label' => 'Англи гарчиг',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "гарчиг оруулна уу ...",
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
            ->add('logoFile', VichFileType::class, [
                'required' => true,
                'label' => 'icon оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add(
                'type',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Байгууллагийн төрөл',
                    'choices' =>
                    array(
                        'Охин компани' => 'SUBSIDIARY',
                        'Хамтрагч байгууллага' => 'PARTNERORGANIZATION'
                    ),
                    'multiple' => false,
                    'required' => false,
                )
            )
            ->add('save', SubmitType::class, array(
                'label' => 'Хадгалах',
                'attr' => array(
                    "class" => "btn btn-primary btn-sm"
                )
            ));;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organization::class,
        ]);
    }
}
