<?php

namespace App\Form;

use App\Entity\Map;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mnName', TextType::class, array(
                'label' => 'Нэр(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('enName', TextType::class, array(
                'label' => 'Нэр(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('cnName', TextType::class, array(
                'label' => 'Нэр(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "оруулна уу ...",
                )
            ))
            ->add('mnDescription', TextareaType::class, array(
                'label' => 'Төслийн тухай(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('enDescription', TextareaType::class, array(
                'label' => 'Төслийн тухай(Англи)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('cnDescription', TextareaType::class, array(
                'label' => 'Төслийн тухай(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "тайлбар оруулна уу ...",
                )
            ))
            ->add('mnBody', CKEditorType::class, array(
                'label' => 'Агуулга(Монгол)',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('enBody', CKEditorType::class, array(
                'label' => 'Агуулга(Англи)',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('cnBody', CKEditorType::class, array(
                'label' => 'Агуулга(Хятад)',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Зураг оруулах',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Зураг харах',
                'download_uri' => static function (Map $config)  {
                    return  "/uploads/image/".$config->getImageUrl();
                },
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
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
                    'required' => false,
                )
            )
            ->add(
                'dataType',
                ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Төслийн төрөл',
                    'choices' =>
                    array(
                        'Төмөр' => 'IRON',
                        'Хүдэр' => 'ORE',
                        'Ган' => 'STEEL'
                    ),
                    'multiple' => false,
                    'required' => false,
                )
            )
            ->add('latitude', NumberType::class, array(
                'label' => 'Өргөрөг',
                'attr' => array(
                    "class" => "form-control",
                )
            ))
            ->add('longitude', NumberType::class, array(
                'label' => 'Уртраг',
                'attr' => array(
                    "class" => "form-control",
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
            'data_class' => Map::class,
        ]);
    }
}
