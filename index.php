<?php

use src\Classes\UnitConverter;

require_once 'Classes/UnitConverter.php';

$result = null;
$conversionDescription = null;
$detailedDescription = null;

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $unitConverter = new UnitConverter();

        // Capture les valeurs soumises par le formulaire
        $value = isset($_POST['value']) ? (float)$_POST['value'] : 0;
        $convertFrom = $_POST['unit_from'] ?? '';
        $convertTo = $_POST['unit_to'] ?? '';
        $rootFontSize = isset($_POST['base_font_size']) ? (float)$_POST['base_font_size'] : 16;

        // Appelle les méthodes de la classe UnitConverter pour obtenir le résultat et la méthode de conversion ainsi que la description détaillée
        [$result, $conversionDescription] = $unitConverter->performConversion($value, $convertFrom, $convertTo);
        $detailedDescription = $unitConverter->generateDescription($convertFrom, $convertTo);
    } catch (InvalidArgumentException $e) {
        $errorMessage = $e->getMessage();
    }
}

include("form.html.php");
include("results.html.php");

