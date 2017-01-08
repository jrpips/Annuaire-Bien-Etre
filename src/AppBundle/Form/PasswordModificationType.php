<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordModificationType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('password', PasswordType::class, array('required' => false,'label_format'=>'Mot de passe actuel'))
                ->add('newPassword', PasswordType::class, array('required' => false,'label_format'=>'Nouveau mot de passe'))
                ->add('confNewPassword', PasswordType::class, array('required' => false,'label_format'=>'Confirmez votre nouveau mot de passe'))
                ->add('Envoyer', SubmitType::class, array('attr' => array('class' => 'btn btn-default pull-right')))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PasswordModification'
        ));
    }

}
