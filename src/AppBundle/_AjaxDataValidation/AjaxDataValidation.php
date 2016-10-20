<?php

namespace AppBundle\AjaxDataValidation;

class AjaxDataValidation {

    static function isValid($val) {
        $pattern = '/^[a-zA-Z]{2,40}$/';
        if (!preg_match($pattern, $val)) {
            $msg = 'trop court';
        } else {
            $msg = 'ok';
        }return array(false, $msg);
    }
} 