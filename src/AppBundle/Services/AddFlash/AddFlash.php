<?php

namespace AppBundle\Services\AddFlash;


//use Symfony\Component\HttpFoundation\Request;


class AddFlash
{
    public function addMsgFlash($request,$statut,$msg,$full=false){
        switch($statut){
            case 'success':$text='La mise à jour de '.$msg.' a été effectuée avec succès!';
                break;
            case 'danger':$text='Une erreur est survenue lors de la mise à jour '.$msg.'!';
                break;
        }
        if($full) $text=$msg;
        $class='alert alert-icon alert-dismissible alert-'.$statut;

            $request->getSession()->getFlashBag()->add(
                'msg', [
                'text' => $text,
                'class' => $class
            ]);

}}