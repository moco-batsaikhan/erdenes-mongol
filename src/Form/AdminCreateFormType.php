<?php

namespace App\Form;

use App\Entity\Banner;
use App\Entity\CmsUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Forms;


class AdminCreateFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $formFactory = Forms::createFormFactory();
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Хэрэглэгчийн нэр',
                'attr' => array(
                    "class" => "form-control",
                    "placeholder" => "Хэрэглэгчийн нэр оруулна уу ...",
                )
            ))

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Оруулсан утгууд тохирохгүй байна',
                'first_options' => ['constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Нууц үг {{ limit }}-с дээш тэмдэгттэй байх ёстой.',
                        'max' => 4096,
                    ]),
                ], 'label' => 'Нууц үг', 'attr' => ['autocomplete' => 'new-password', "class" => "form-control"]],
                'second_options' => ['constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Нууц үг {{ limit }}-с дээш тэмдэгттэй байх ёстой.',
                        'max' => 4096,
                    ]),
                ], 'label' => 'Нууц үг давт', 'attr' => ['autocomplete' => 'new-password', "class" => "form-control"]],
                'mapped' => false,
                'required' => true,
            ])

            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CmsUser::class,
        ]);
    }
}
