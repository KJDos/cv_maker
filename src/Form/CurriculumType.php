<?php

namespace App\Form;

use App\Entity\Curriculum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CurriculumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('title')
            ->add('underTitle')
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' =>[
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/jpeg,', 'image/pjpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ]
            ])
            ->add('website')
            ->add('github')
            ->add('adress')
            ->add('phone')
            ->add('phoneAlt')
            ->add('email')
            ->add('skills', CollectionType::class,
                [
                    'entry_type' => SkillType::class,
                    'allow_add' => true,
                ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Curriculum::class,
        ]);
    }
}
