<?php

namespace App\Form;

use App\Entity\CmsUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;


class AdminCreateFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Хэрэглэгчийн нэр',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "Хэрэглэгчийн нэр оруулна уу ...",
                )
            ))
            ->add('roles', ChoiceType::class, array(
                    'attr' => array('class' => 'form-control',
                        'style' => 'margin:5px 0;height: 200px'),
                    'label' => 'Админ эрх',
                    'choices' =>
                        array
                        (
                            'Супер админ' => array
                            (
                                'Сонгох' => 'ROLE_SUPER_ADMIN'
                            ),

                            'Мэдээний админ' => array
                            (
                                'Сонгох' => 'ROLE_NEWS_ADMIN'
                            ),
                        )
                ,
                    'multiple' => true,
                    'required' => true,
                )
            )
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Оруулсан утгууд тохирохгүй байна',
                'options' => ['attr' => ['class' => 'form-control']],
                'required' => true,
                'first_options' => ['label' => 'Нууц үг'],
                'second_options' => ['label' => 'Нууц үг давт'],
            ])
            ->add('isVerified', ChoiceType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Төлөв',
                    'choices' =>
                        array
                        (
                            'Идэвхитэй' => true,
                            'Идэвхигүй' => false
                        ),
                    'multiple' => false,
                    'required' => true,
                )
            )
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
            'data_class' => CmsUser::class,
        ]);
    }
}
