<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use AppBundle\Form\InternauteType;
use AppBundle\Form\AdresseUtilisateurType;

class UtilisateurType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', EmailType::class, array('required' => false))
                ->add('pwd', PasswordType::class, array('required' => false))
                ->add('adresseNumero', IntegerType::class, array('required' => false))
                ->add('adresseRue', TextType::class, array('required' => false))
//                ->add('inscription', 'date')
//                ->add('typeUtilisateur')
//                ->add('essaiPwd')
//                ->add('banni')
//                ->add('inscriptionConf')
                ->add('adresseUtilisateur',AdresseUtilisateurType::class)
        //        ->add('internaute',InternauteType::class)

        ;
    }
  
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur'
        ));
    }

}
