<?php

namespace AppBundle\Services\FormErrorMessages;

class FormErrorMessages {

     function getErrorMessages(\Symfony\Component\Form\Form $form) {

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
        
        //foreach ($form->all() as $key => $child) {
        //   if ($err == $this->getErrorMessages($child))
        //         $errors[$key] = $err;
        //   }
        //return $errors;
    }
}
