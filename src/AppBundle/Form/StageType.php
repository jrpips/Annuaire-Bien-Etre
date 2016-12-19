<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('description', TextareaType::class, array('required' => false))
            ->add('tarif', IntegerType::class, array('required' => false))
            ->add('info', TextType::class, array('required' => false))
            ->add('dateDebut', DateType::class, array('required' => false, 'placeholder' => array(
               'day' => 'Jour', 'month' => 'Mois','year' => 'Année'
            )))
            ->add('dateFin',  DateType::class, array('required' => false, 'placeholder' => array(
                'day' => 'Jour', 'month' => 'Mois','year' => 'Année'
            )))
            ->add('affichageDebut',  DateType::class, array('required' => false, 'placeholder' => array(
                'day' => 'Jour', 'month' => 'Mois','year' => 'Année'
            )))
            ->add('affichageFin', DateType::class, array('required' => false, 'placeholder' => array(
                'day' => 'Jour', 'month' => 'Mois','year' => 'Année'
            )))
            ->add('Envoyer', SubmitType::class,array('attr'=>array('class'=>'btn btn-default pull-right')))
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
