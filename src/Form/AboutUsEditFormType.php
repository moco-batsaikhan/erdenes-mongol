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
            ->add('mnValue', TextType::class, array(
                'label' => 'Үнэт зүйл(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enValue', TextType::class, array(
                'label' => 'Үнэт зүйл(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnValue', TextType::class, array(
                'label' => 'Үнэт зүйл(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('mnVision', TextType::class, array(
                'label' => 'Алсын хараа(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enVision', TextType::class, array(
                'label' => 'Алсын хараа(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnVision', TextType::class, array(
                'label' => 'Алсын хараа(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('mnStrategyPurpose', TextType::class, array(
                'label' => 'Стратегийн зорилго(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enStrategyPurpose', TextType::class, array(
                'label' => 'Стратегийн зорилго(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnStrategyPurpose', TextType::class, array(
                'label' => 'Стратегийн зорилго(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Зураг оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'download_uri' => static function (AboutUs $config)  {
                    return  "/uploads/image/".$config->getImageUrl();
                },
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('mnPrinciples', TextType::class, array(
                'label' => 'Эрхэм зорилго(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enPrinciples', TextType::class, array(
                'label' => 'Эрхэм зорилго(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnPrinciples', TextType::class, array(
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
