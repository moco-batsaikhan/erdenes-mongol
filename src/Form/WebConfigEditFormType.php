<?php

namespace App\Form;

use App\Entity\WebConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;


class WebConfigEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('backgroundColor',  TextType::class, array(
                'label' => 'Цэс арын өнгө',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'required' => false,
            ))
            ->add('colorCode',  TextType::class, array(
                'label' => 'Цэс текстийн өнгө',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "өнгө оруулна уу ...",
                ),
                'empty_data' => '',
                'required' => false,
            ))
            ->add('transparentImageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Ил тод хэсгийн зураг, тохирох хэмжээ(1440*410px)',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Logo харах',
                'download_uri' => static function (WebConfig $config)  {
                    return  "/uploads/image/".$config->getTransparentImage();
                },
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('sloganImageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Уриа үг хэсгийн зураг, тохирох хэмжээ(1440*360px)',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Logo харах',
                'download_uri' => static function (WebConfig $config)  {
                    return  "/uploads/image/".$config->getSloganImage();
                },
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('coverImageFile', VichFileType::class, [
                'required' => false,
                'label' => 'Динамик хуудаснуудын header зураг',
                'allow_delete' => true,
                'allow_file_upload' => true,
                'download_label' => 'Logo харах',
                'download_uri' => static function (WebConfig $config)  {
                    return  "/uploads/image/".$config->getCoverImage();
                },
                'delete_label' => 'Устгах',
                'attr' => array(
                    "class" => "form-control",
                )
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin-top:15px'],
                'label' => 'Хадгалах'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WebConfig::class,
        ]);
    }
}
