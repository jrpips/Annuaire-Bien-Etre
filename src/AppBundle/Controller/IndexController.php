<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Utilisateur;
use AppBundle\AjaxDataValidation\AjaxDataValidation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function indexAction() {
        $prestataires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prestataire')->findAll();
        $promos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Promotion')->findAll();
        $stages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Stage')->findAll();
        $services = $this->getDoctrine()->getManager()->getRepository('AppBundle:CategService')->findAll();
        dump($prestataires);
        return $this->render('accueil/index.html.twig', array(
                    'p' => $prestataires,
                    'promos' => $promos,
                    'stages' => $stages,
                    'services' => $services
        ));
    }

    /**
     * @Route("/about",name="about")
     */
    public function aboutAction() {
        return $this->render('accueil/login.html.twig');
    }

    /**
     * @Route("/contact",name="contact")
     */
    public function contactAction() {
        
    }

    /**
     * @Route("/login",name="login")
     */
    public function loginAction() {
        $response = new JsonResponse;
        $response->setData(array('data' => '$errors')); //$this->render('accueil/login.html.twig');
        return $response;
    }

    /**
     * @Route("/subscribe/user",name="subscribeUser")
     */
    public function subscribeUserAction(Request $request) {

        $user = new Utilisateur();
        $form = $this->createFormBuilder($user, ['action' => $this->generateUrl('subscribeUser')]);

        $form = $form
                ->add('adresseRue', TextType::class, array('required' => false))
                ->add('adresseNumero', TextType::class, array('required' => false))
                ->add('email', TextType::class, array('required' => false))
                ->add('Envoyer', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        //ajax
        if ($request->getMethod() == 'POST'){//if ($form->isSubmitted()) {
//            $form->handleRequest($request);
//            $val = $request->request->get('value');
//            $form->submit($request->request->all());
//            $form->submit($val);

            if (!$form->isValid()) {

                $errors = $this->getErrorMessages($form);

                return new JsonResponse(array('errors' => $errors,));
            }
            if ($form->isValid()) {

                return $this->redirectToRoute('home');
            }
            /*
              $validator = $this->get('validator');
              $listErrors = $validator->validate($user);
              if (count($listErrors) > 0) {
              return new JsonResponse(array("errors" => $listErrors,));
              } else {
              return new JsonResponse(["rep" => "L'annonce est valide !"]);
              } */
        }
        if (!$form->isSubmitted()) {
            return $this->render('accueil/login.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $user
            ));
        }
    }

    protected function getErrorMessages(\Symfony\Component\Form\Form $form) {

        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }
        return $errors;
//        foreach ($form->all() as $key => $child) {
//            if ($err == $this->getErrorMessages($child))
//                $errors[$key] = $err;
//        }
//        return $errors;
    }

}
