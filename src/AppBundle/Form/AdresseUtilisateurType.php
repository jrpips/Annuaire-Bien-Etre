<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Services\SearchCodePostal\SearchCodePostal;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class AdresseUtilisateurType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('codePostal', IntegerType::class, array('required' => false))
                ->add('commune', ChoiceType::class, array('required' => false))
                ->add('localite', TextType::class, array('required' => false))
        //->add('utilisateur')
        ;

        $getNameCommune = function(FormInterface $form, $codePostal) {
            $beurk = new \AppBundle\Services\SearchPostalCode\SearchPostalCode();

            $communes =  $beurk->getData($codePostal); 
                   // $this->container->get('app.searchpostalcode')->getData($codePostal);

            $options = $communes['communes'];
            $form->add('commune', ChoiceType::class, array('attr' => array('class' => 'commune'),
                'choices' => $options));
        };

        $builder->get('codePostal')->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) use ($getNameCommune) {
            $getNameCommune($event->getForm()->getParent(), $event->getForm()->getData());
        });
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AdresseUtilisateur',
             'cascade_validation' => true
        ));
    }

}
