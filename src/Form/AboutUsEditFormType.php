<?php

namespace App\Form;

use App\Entity\AboutUs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AboutUsEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnDescription', TextareaType::class, array(
                'label' => 'Агуулга Монгол',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('enDescription', TextareaType::class, array(
                'label' => 'Агуулга Англи',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('cnDescription', TextareaType::class, array(
                'label' => 'Агуулга Хятад',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('mnValue', TextareaType::class, array(
                'label' => 'Үнэт зүйл(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enValue', TextareaType::class, array(
                'label' => 'Үнэт зүйл(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnValue', TextareaType::class, array(
                'label' => 'Үнэт зүйл(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('mnVision', TextareaType::class, array(
                'label' => 'Алсын хараа(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enVision', TextareaType::class, array(
                'label' => 'Алсын хараа(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnVision', TextareaType::class, array(
                'label' => 'Алсын хараа(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('mnStrategyPurpose', TextareaType::class, array(
                'label' => 'Стратегийн зорилго(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enStrategyPurpose', TextareaType::class, array(
                'label' => 'Стратегийн зорилго(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnStrategyPurpose', TextareaType::class, array(
                'label' => 'Стратегийн зорилго(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Зураг оруулах, тохирох хэмжээ(420*500px)',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => false,
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('mnPrinciples', TextareaType::class, array(
                'label' => 'Эрхэм зорилго(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enPrinciples', TextareaType::class, array(
                'label' => 'Эрхэм зорилго(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnPrinciples', TextareaType::class, array(
                'label' => 'Эрхэм зорилго(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('firsNumber', TextType::class, array(
                'label' => 'Ашиглалтын тусгай зөвшөөрөл',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('secondNumber', TextType::class, array(
                'label' => 'Хайгуулын тусгай зөвшөөрөл',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('thirdNumber', TextType::class, array(
                'label' => 'Нэгдлийн компаниуд',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('fourthNumber', TextType::class, array(
                'label' => 'Нийт ажилчид',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AboutUs::class,
        ]);
    }
}
