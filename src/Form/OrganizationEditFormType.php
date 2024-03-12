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

class OrganizationEditFormType extends AbstractType
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
            // ->add('mnDescription', TextType::class, array(
            //     'label' => 'Монгол тайлбар',
            //     'attr' => array(
            //         "class" => "form-control",
            //         "placeholder" => "тайлбар оруулна уу ...",
            //     )
            // ))
            // ->add('enDescription', TextType::class, array(
            //     'label' => 'Англи тайлбар',
            //     'attr' => array(
            //         "class" => "form-control",
            //         "placeholder" => "тайлбар оруулна уу ...",
            //     )
            // ))
            // ->add('cnDescription', TextType::class, array(
            //     'label' => 'Хятад тайлбар',
            //     'attr' => array(
            //         "class" => "form-control",
            //         "placeholder" => "тайлбар оруулна уу ...",
            //     )
            // ))
            // ->add('imageFile', VichFileType::class, [
            //     'required' => true,
            //     'label' => 'Зураг оруулах',
            //     'allow_delete' => true,
            //     'allow_file_upload' => true,
            //     'delete_label' => 'Устгах',
            //     'attr' => array(
            //         "class" => "form-control",
            //     )
            // ])
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
            // ->add('webUrl', TextType::class, array(
            //     'label' => 'Байгууллагийн веб хаяг',
            //     'attr' => array(
            //         "class" => "form-control",
            //         "placeholder" => "веб хаяг оруулна уу ...",
            //     )
            // ))
            // ->add('address', TextType::class, array(
            //     'label' => 'Хаяг',
            //     'attr' => array(
            //         "class" => "form-control",
            //         "placeholder" => "хаяг оруулна уу ...",
            //     )
            // ))
            // ->add('contact', TextType::class, array(
            //     'label' => 'Холбоо барих дугаар ',
            //     'attr' => array(
            //         "class" => "form-control",
            //         "placeholder" => "дугаар оруулна уу ...",
            //     )
            // ))
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
