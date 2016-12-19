<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\ImageType;

class InternauteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('required' => false))
            ->add('prenom', TextType::class, array('required' => false))
            ->add('newsletter', CheckboxType::class, array('label' => 'Recevoir notre newsletter', 'required' => false))
            ->add('image', ImageType::class, array('required' => false))
            //->add('Envoyer', SubmitType::class, array('attr' => array('class' => 'btn btn-default pull-right')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Internaute',
            'allow_extra_fields' => true,
        ));
    }

}
