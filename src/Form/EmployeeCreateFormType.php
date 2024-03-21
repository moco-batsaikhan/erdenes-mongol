<?php

namespace App\Form;

use App\Entity\Employee;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnName', TextType::class, array(
                'label' => 'Нэр(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )
            ->add('enName', TextType::class, array(
                'label' => 'Нэр(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )
            ->add('cnName', TextType::class, array(
                'label' => 'Нэр(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )
            ->add('mnDivision', TextType::class, array(
                'label' => 'Албан тушаал(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )

            ->add('enDivision', TextType::class, array(
                'label' => 'Албан тушаал(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )

            ->add('cnDivision', TextType::class, array(
                'label' => 'Албан тушаал(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )
            ->add('email', TextType::class, array(
                'label' => 'И-мэйл',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )
            ->add('phone', NumberType::class, array(
                'label' => 'Дугаар',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )
            ->add('department', TextType::class, array(
                'label' => 'Алба, хэлтэс',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            )
            )
            ->add('priority', NumberType::class, array(
                'label' => 'Дарааалал',
                'attr' => array(
                    "class" => "form-control",
                )
            )
            )
            ->add('imageFile', VichFileType::class, [
                'required' => true,
                'label' => 'Зураг оруулах, тохирох хэмжээ(350*350px)',
                'allow_delete' => true,
                'download_label' => false,
                'allow_file_upload' => true,
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
                    'label' => 'Төрөл',
                    'choices' =>
                        array(
                            'Удирдлагын баг' => true,
                            'Ажилтан' => false
                        ),
                    'multiple' => false,
                    'required' => false,
                )
            )
            ->add('mnExperience', CKEditorType::class, array(
                'label' => 'Ажлын туршлага(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                )
            )
            )

            ->add('enExperience', CKEditorType::class, array(
                'label' => 'Ажлын туршлага(Англи)',
                'attr' => array(
                    "class" => "form-control",
                )
            )
            )

            ->add('cnExperience', CKEditorType::class, array(
                'label' => 'Ажлын туршлага(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                )
            )
            )
            ->add('facebook', TextType::class, array(
                'label' => 'facebook хаяг',
                'attr' => array(
                    "class" => "form-control",
                ),
                'required' => false,
            )
            )
            ->add('twitter', TextType::class, array(
                'label' => 'Twitter хаяг',
                'attr' => array(
                    "class" => "form-control",
                ),
                'required' => false,
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
            'data_class' => Employee::class,
        ]);
    }
}
