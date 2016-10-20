<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use AppBundle\Form\UtilisateurType;
use AppBundle\Form\ImageType;

class PrestataireType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('required' => false))
            ->add('siteInternet', TextType::class, array('required' => false))
//            ->add('email', EmailType::class, array('required' => false))
            ->add('telephone', TextType::class, array('required' => false))
            ->add('tva', TextType::class, array('required' => false))
            ->add('utilisateur', UtilisateurType::class)
//            ->add('image', ImageType::class)
            //->add('internautes', TextType::class, array('required' => false))
//            ->add('categServices', EntityType::class, array('required' => false))
            ->add('Envoyer', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Prestataire'
        ));
    }
}
