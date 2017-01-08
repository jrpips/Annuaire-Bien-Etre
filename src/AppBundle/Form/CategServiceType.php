<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategServiceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('required' => false))
            ->add('description', TextareaType::class, array('required' => false))
            ->add('enAvant', CheckboxType::class, array('required' => false))
            //->add('valide', CheckboxType::class, array('required' => false))
            //->add('prestataires')
            ->add('image', ImageType::class, array('required' => false))
            ->add('Envoyer', SubmitType::class,array('attr'=>array('class'=>'btn btn-default pull-right')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CategService'
        ));
    }
}
