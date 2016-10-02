<?php

// récupération des données sur le site bpost

$doc = new DOMDocument;
$doc->loadHTMLFile('http://www.bpost2.be/zipcodes/files/zipcodes_prov_fr.html?_ga=1.96820831.1334083198.1473325327'); // source
$tableElements = $doc->getElementsByTagName('td'); // élément cible

$nbElements = $tableElements->length;

for ($i = 0; $i < $nbElements; $i++) {
    if (preg_match("#^[1-9]{1}[0-9]{3}$#", $tableElements->item($i)->nodeValue)) {
        $codes_postaux[$tableElements->item($i)->nodeValue][] = /* ucwords(strtolower( */$tableElements->item($i + 1)->nodeValue/* )) */; // valeur
    }//tri et récupération des données (cp et commune(s) associée(s))
}

// formatage et concaténation $row=array()

$row = '<?php $codes_postaux=array(';
foreach ($codes_postaux as $k => $v) {
    $row .="'$k'=>array(";
    $i = 0;
    foreach ($codes_postaux[$k] as $value) {
        $value = addslashes($value);
        $row .="$i=>'$value',";
        $i++;
    }
    $row = substr($row, 0, -1) . "),";
}
$row = substr($row, 0, -1) . ");";

// écriture du fichier cp.php 

$file = "cp.php";
$mode = "w+";
$fichier = fopen($file, $mode);
fwrite($fichier, $row);
fclose($fichier);


