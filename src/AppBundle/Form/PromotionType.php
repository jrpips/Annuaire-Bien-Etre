<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Utilisateur;


class PromotionType extends AbstractType
{
    /*private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }*/
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $options['user'];

        $builder
            ->add('nom', TextType::class, array('required' => false))
            ->add('description', TextareaType::class, array('required' => false))
            //->add('pdf')
            ->add('dateDebut', DateType::class, array('required' => false))
            ->add('dateFin', DateType::class, array('required' => false))
            ->add('affichageDebut', DateType::class, array('required' => false))
            ->add('affichageFin', DateType::class, array('required' => false))
            ->add('categService', EntityType::class, array(//TODO : utiliser les events
                'class' => 'AppBundle:CategService',
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('cs')->leftJoin('cs.prestataires', 'p')->andWhere('p.id like :id')->setParameter('id', $user);
                },
                'choice_label' => 'nom',
                'label' => 'Service associé'))
            ->add('Envoyer', SubmitType::class, array('attr' => array('class' => 'btn btn-default pull-right')));

       /* $user = $this->tokenStorage->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($user) {
                $form = $event->getForm();

                $formOptions = array(
                    'class'         => Utilisateur::class,
                    'query_builder' => function (EntityRepository $er) use ($user) {
                        return $er->createQueryBuilder('cs')
                            ->leftJoin('cs.prestataires', 'p')
                            ->andWhere('p.id like :id')
                            ->setParameter('id', $user);
                    },
                    'choice_label' => 'nom',
                    'label' => 'Service associé'
                );
                $form->add('categServices', EntityType::class, $formOptions);
            }*/

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'AppBundle\Entity\Promotion',
                'allow_extra_fields' => true,
                'user' => null
            ))
            ->setDefined(array('user'));
    }

}
