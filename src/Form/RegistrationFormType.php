<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,["label" => 'FORM.USERNAME.LABEL'])
            ->add('password', RepeatedType::class, [
                "type"  =>  PasswordType::class,
                "invalid_message" => 'FORM.USER.PASSWORD.ERROR',
                'first_options'  => ['label' => 'FORM.PASSWORD.LABEL1'],
                'second_options' => ['label' => 'FORM.PASSWORD.LABEL2']
            ])->add('email', EmailType::class,['label' => 'FORM.EMAIL.LABEL'])->add('termAccepted', CheckboxType::class, ['label' => 'FORM.TOS.LABEL'
            ]);

        if($options['standalone']){
            $builder->add('submit', SubmitType::class,[
                'label' => 'FORM.SUBMIT.LABEL',
                'attr'  =>  [
                    'class' => 'btn-success'
                ]]);
        }


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'standalone' => false
        ]);
    }
}
