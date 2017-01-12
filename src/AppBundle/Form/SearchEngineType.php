<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\ImageType;

class SearchEngineType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('required' => false))
            //->add('service', TextType::class, array('required' => false))
            ->add('service',EntityType::class,array(
                'class' => 'AppBundle:CategService',
                'choice_label' => 'nom',
                'choice_value'=>'nom'
            ))
            ->add('commune', TextType::class, array('required' => false))
            ->add('cp', IntegerType::class, array('required' => false,'label_format'=>'Code postal'))
            ->add('localite', TextType::class, array('required' => false,'label_format'=>'Province'))
            ->add('rechercher', SubmitType::class);
    }

    public function getName()
    {
        return 'search_engine';
    }

}
