<?php

namespace AppBundle\Controller\SystemController\SimpleRequestAjax;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
//use AppBundle\Entity\SignUp;
//use AppBundle\Entity\Internaute;
//use AppBundle\Entity\Utilisateur;
//use AppBundle\Form\SignUpType;
//use AppBundle\Form\InternauteType;
//use AppBundle\Form\UtilisateurType;

class SimpleRequestAjaxController extends Controller {

    /**
     * @Route("/inscription/autocompletion",options={"expose"=true},name="autocomplete")
     */
    public function autoCompleteAjaxAction(Request $request) {//chargement des communes en fonction du cp
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {
            $val = $request->request->get('valeur');
            $response = $this->container->get('app.searchpostalcode')->getData($val);

            return new JsonResponse($response);
        }
    }

}
