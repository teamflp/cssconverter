<?php

use App\Cssconverter\Classes\UnitConverter;

require_once 'vendor/autoload.php';

$result = null;
$conversionDescription = null;
$detailedDescription = null;

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $unitConverter = new UnitConverter();

        // Capture les valeurs soumises par le formulaire
        $value = $_POST['value'] ?? 0.0; // Valeur par défaut
        $convertFrom = $_POST['unit_from'] ?? '';
        $convertTo = $_POST['unit_to'] ?? '';
        $rootFontSize = $_POST['base_font_size'] ?? 16.0;

        $unitConverter->setRootFontSize((float)$rootFontSize); // Définit la taille de police de base personnalisée

        // Appelle les méthodes de la classe UnitConverter pour obtenir le résultat et la méthode de conversion ainsi que la description détaillée
        [$result, $conversionDescription] = $unitConverter->performConversion($value, $convertFrom, $convertTo);
        $detailedDescription = $unitConverter->generateDescription($convertFrom, $convertTo);
    } catch (InvalidArgumentException $e) {
        $errorMessage = $e->getMessage();
    }
}

include("form.html.php");
include("results.html.php");

