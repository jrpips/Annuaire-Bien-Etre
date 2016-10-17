<?php

namespace AppBundle\Services\SearchPostalCode;

class SearchPostalCode {

    private $cp = [];
    private $provinces = [];

    public function __construct() {

        require_once 'cp.php';
        require_once 'provinces.php';

        $this->cp = $codes_postaux;
        $this->provinces = $provinces;
    }

    public function getData($val) {
        if (array_key_exists($val, $this->cp)) {
            foreach ($this->cp[$val] as $value) {
                $communes[$value] = $value;
            }
            $province = $this->provinces[substr($val, 0, 1) - 1];
            $valide = true;
        } else {
            $communes = ['Aucunes communes associées à ce code postal!'];
            $province = null;
            $valide = false;
        }
        return ['communes' => $communes, 'province' => $province, 'valide' => $valide];
    }

}
