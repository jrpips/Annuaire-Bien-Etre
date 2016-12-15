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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AppBundle\Form\InternauteType;
use AppBundle\Form\AdresseUtilisateurType;

class UtilisateurType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', EmailType::class, array('required' => false))
                ->add('password', PasswordType::class, array('required' => false))
//                ->add('confPwd', PasswordType::class, array('required' => false))
                ->add('adresseNumero', IntegerType::class, array('required' => false))
                ->add('adresseRue', TextType::class, array('required' => false))
                ->add('username', TextType::class, array('required' => false))

                ->add('adresseUtilisateur', AdresseUtilisateurType::class)
                //->add('Envoyer', SubmitType::class,array('attr'=>array('class'=>'btn btn-default pull-right')))
         
              
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur',
         
        ));
    }

}
