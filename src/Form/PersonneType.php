<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Personne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('name')
            ->add('age')
            ->add('job')
            ->add('path')
            ->add('image', FileType::class, array(
                'mapped'=> false,
                'constraints'=> array(
                    new Image()
                )
            ))
            ->add('cin')
            ->add('section')
            ->add('cours', EntityType::class, array(
                'class' => Cours::class,
                'choice_label' => 'designation',
                'multiple' => true,
                'expanded' => true
            ))
            ->add('socialMedia')
            ->add('envoyer', SubmitType::class)
//            ->add('pays', CountryType::class, array(
//                'mapped' => false
//            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
