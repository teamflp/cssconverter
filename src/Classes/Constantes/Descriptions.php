<?php
namespace App\Cssconverter\Classes\Constantes;

class Descriptions
{
    // Conversion methods
    const INVALID_CONVERSION = "Conversion de %s à %s non supportée.";
    const NO_CONVERSION_NEEDED = "%s%s = %s%s (Pas de conversion nécessaire)";
    const PX_TO_EM_REM_CONVERSION = "%spx / %s (Root Font Size) = %s%s. La conversion implique de diviser la taille de police en pixels par la taille de police de base (%s) pour obtenir la taille en em/rem.";
    const PX_TO_PERCENT_CONVERSION = "(%spx / %s) * 100 = %s%s. La conversion implique de diviser la taille de police en pixels par la taille de police de base (%s) pour obtenir la taille en pourcentage.";
    const EM_REM_TO_PX_CONVERSION = "%s%s * %s (Root Font Size) = %spx. La conversion implique de multiplier la taille de police en em/rem par la taille de police de base (%s) pour obtenir la taille en pixels.";
    const EM_REM_TO_PERCENT_CONVERSION = "%s%s * 100 = %s%s. La conversion implique de multiplier la taille de police en em/rem par 100 pour obtenir la taille en pourcentage.";
    const PERCENT_TO_PX_CONVERSION = "(%s%% / 100) * %s = %spx. La conversion implique de diviser la taille de police en pourcentage par 100, puis de multiplier le résultat par la taille de police de base (%s) pour obtenir la taille en pixels.";
    const PERCENT_TO_EM_REM_CONVERSION = "%s%% / 100 = %s%s. La conversion implique de diviser la taille de police en pourcentage par 100 pour obtenir la taille en em/rem.";

    // Descriptions
    const DESCRIPTION_PX_TO_EM_REM = "Pour convertir des pixels (px) en em/rem, utilisez la formule : \\( \\frac{px}{%s} = em/rem \\).";
    const DESCRIPTION_PX_TO_PERCENT = "Pour convertir des pixels (px) en pourcentage (%), utilisez la formule : \\( \\frac{px}{%s} \\times 100 = %% \\).";
    const DESCRIPTION_EM_REM_TO_PX = "Pour convertir des rem/em en pixels (px), utilisez la formule : \\( rem/em \\times %s = px \\).";
    const DESCRIPTION_EM_REM_TO_PERCENT = "Pour convertir des rem/em en pourcentage (%), utilisez la formule : \\( rem/em \\times 100 = %% \\).";
    const DESCRIPTION_PERCENT_TO_PX = "Pour convertir un pourcentage (%) en pixels (px), utilisez la formule : \\( \\frac{%%}{100} \\times %s = px \\).";
    const DESCRIPTION_PERCENT_TO_EM_REM = "Pour convertir un pourcentage (%) en rem/em, utilisez la formule : \\( \\frac{%s%%}{100} = rem/em \\).";
    const DESCRIPTION_NOT_APPLICABLE = "Cette conversion n'est pas applicable car les unités de conversion (\\( %s \\rightarrow %s \\)) choisies sont identiques. Par conséquent, la taille de police reste la même.";
    const DESCRIPTION_NO_CONVERSION_NEEDED = "";
    const SAME_UNIT_CONVERSION = "La conversion de \\( %s \\rightarrow %s \\) n'est pas nécessaire car les unités sont identiques.";
}

