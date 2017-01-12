<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PrestataireType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('required' => false,'label_format'=>'Nom de votre société'))
            ->add('siteInternet', TextType::class, array('required' => false))
            ->add('telephone', TextType::class, array('required' => false,'label_format'=>'Téléphone'))
            ->add('tva', TextType::class, array('required' => false,'label_format'=>'Votre numéro de TVA'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Prestataire',
            'allow_extra_fields' => true,

        ));
    }
}
