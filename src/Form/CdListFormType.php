<?php

namespace App\Form;

use App\Entity\CdList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class CdListFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('interpret')
            ->add('album')
            ->add('genre')
            ->add('rls', DateType::Class, array(
                'label' => 'Release (Year)',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy'
            ))
            ->add('price', MoneyType::class, [
                'currency' => 'CZK'
            ])
            ->add('rating', PercentType::class, [
                'type' => 'integer',
                'invalid_message' => "This value is not valid"
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (JPEG or PNG file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image file',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CdList::class,
        ]);
    }
}
