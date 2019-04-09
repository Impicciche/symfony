<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PictureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'FORM.PICTURE.TITLE.LABEL'])
            ->add('description', TextType::class, ['label'  => 'FORM.PICTURE.DESCRIPTION.LABEL'])
            ->add('tags', EntityType::class,
                [
                    'label' => 'FORM.PICTURE.TAGS.LABEL',
                    'class' =>  Tag::class,
                    'choice_label'  => 'label',
                    'multiple'  =>  true,
                    'required'  =>  false
                ])
            ->add('file', FileType::class, [
                'label' => 'FORM.PICTURE.FILE.LABEL',
                'mapped'    =>  false,
                'constraints'   =>  [
                    new Image([
                    'mimeTypes'  =>  ['image/png' , 'image/jpg', 'image/jpeg'],
                    'maxSize'   =>  '5M',
                    'minWidth'   =>  640,
                    'minHeight' =>  640
                ])
                    ]
            ]);

        if($options['standalone']==true){
            $builder->add('submit',SubmitType::class,
                [
                    'label' =>  'FORM.PICTURE.SUBMIT.LABEL',
                    'attr'  =>  [
                        'class' =>  'btn-success'
                    ]
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
            'standalone' => false
        ]);
    }
}
