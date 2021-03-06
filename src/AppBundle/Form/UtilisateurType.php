<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use AppBundle\Form\InternauteType;
use AppBundle\Form\AdresseUtilisateurType;

class UtilisateurType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('required' => false))
            ->add('adresseNumero', IntegerType::class, array('required' => false, 'label_format' => 'Numéro'))
            ->add('adresseRue', TextType::class, array('required' => false, 'label_format' => 'Rue'))
            ->add('username', TextType::class, array('required' => false, 'label_format' => 'Pseudo'))
            ->add('adresseUtilisateur', AdresseUtilisateurType::class)
            ->add('Envoyer', SubmitType::class, array('attr' => array('class' => 'btn btn-default pull-right')));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $user = $event->getData();
            $form = $event->getForm();

            if (!$user || null === $user->getId()) {
                $form
                    ->add('password', PasswordType::class, array('required' => false, 'label_format' => 'Mot de passe'))
                    ->add('confPwd', PasswordType::class, array('required' => false, 'label_format' => 'Confirmez votre MDP'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur',
            'allow_extra_fields' => true,
        ));
    }
}
