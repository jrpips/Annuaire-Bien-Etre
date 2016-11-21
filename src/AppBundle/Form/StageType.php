<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('required' => false))
            ->add('description', TextType::class, array('required' => false))
            ->add('tarif', IntegerType::class, array('required' => false))
            ->add('info', TextType::class, array('required' => false))
            ->add('dateDebut', DateType::class, array('required' => false))
            ->add('dateFin',  DateType::class, array('required' => false))
            ->add('affichageDebut',  DateType::class, array('required' => false))
            ->add('affichageFin', DateType::class, array('required' => false))
            ->add('Envoyer',SubmitType::class)
            //->add('prestataire')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Stage'
        ));
    }
}
