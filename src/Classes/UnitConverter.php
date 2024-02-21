<?php

namespace App\Cssconverter\Classes;

use InvalidArgumentException;

class UnitConverter
{
    private float $rootFontSize;
    private array $conversionCache = [];

    public function __construct(float $rootFontSize = 16)
    {
        $this->rootFontSize = $rootFontSize;
    }

    /**
     * Description: Convertit une valeur de taille de police d'une unité à une autre.
     * @param float $value
     * @param string $convertFrom
     * @param string $convertTo
     * @return array
     */
    public function performConversion(float $value, string $convertFrom, string $convertTo): array
    {
        if ($convertFrom === $convertTo) {
            $message = "Conversion non applicable. Voir la description.";
            $result = $value;

            return [$result, $message];

        }

        if (!$this->isValidUnit($convertFrom) || !$this->isValidUnit($convertTo)) {
            throw new InvalidArgumentException("Unités fournies pour la conversion invalides.");
        }

        $cacheKey = $convertFrom . '_' . $convertTo . '_' . $value;
        if (isset($this->conversionCache[$cacheKey])) {
            return $this->conversionCache[$cacheKey];
        }

        $result = match ($convertFrom) {
            'px' => $this->pxToOthers($value, $convertTo),
            '%' => $this->percentToOthers($value, $convertTo),
            'em', 'rem' => $this->relativeToOthers($value, $convertFrom, $convertTo),
            default => throw new InvalidArgumentException("La conversion de $convertFrom à $convertTo n'est pas prise en charge."),
        };

        $conversionMethod = $this->generateConversionMethod($value, $convertFrom, $result, $convertTo);
        $this->conversionCache[$cacheKey] = [$result, $conversionMethod];
        return [$result, $conversionMethod];
    }

    /**
     * Description: Définit la taille de police de base pour les conversions.
     * @param float $value
     * @param string $convertTo
     * @return string
     */
    public function setRootFontSize(float $fontSize): void
    {
        $this->rootFontSize = $fontSize;
    }

    /**
     * Description: Convertit une valeur de taille de police en pixels en em/rem.
     * @param float $value
     * @param string $convertTo
     * @return float|null
     */
    private function pxToOthers(float $value, string $convertTo): ?float
    {
        return match ($convertTo) {
            'em', 'rem' => $value / $this->rootFontSize,
            '%' => ($value / $this->rootFontSize) * 100,
            default => null,
        };
    }

    /**
     * Description: Convertit une valeur de taille de police en pourcentage en pixels, em ou rem.
     * @param float $value
     * @param string $convertTo
     * @return float|null
     */
    private function percentToOthers(float $value, string $convertTo): ?float
    {
        return match ($convertTo) {
            'px' => ($value / 100) * $this->rootFontSize,
            'rem', 'em' => $value / 100,
            default => null,
        };
    }

    /**
     * Description: Convertit une valeur de taille de police en em/rem en pixels, pourcentage ou em/rem.
     * @param float $value
     * @param string $convertFrom
     * @param string $convertTo
     * @return float|null
     */
    private function relativeToOthers(float $value, string $convertFrom, string $convertTo): ?float
    {
        return match ($convertTo) {
            'px' => $value * $this->rootFontSize,
            '%' => $value * 100,
            'em', 'rem' => $value, // Pas de conversion nécessaire si les unités sont identiques
            default => null,
        };
    }

    /**
     * Description: Vérifie si l'unité de taille de police est valide.
     * @param string $unit
     * @return bool
     */
    private function isValidUnit(string $unit): bool
    {
        $validUnits = ['px' => true, 'em' => true, 'rem' => true, '%'=> true];
        return isset($validUnits[$unit]);
    }

    /**
     * Description: Génère une méthode de conversion pour une valeur donnée.
     * @param float $value
     * @param string $convertFrom
     * @param float|null $result
     * @param string $convertTo
     * @return string
     */
    private function generateConversionMethod(float $value, string $convertFrom, ?float $result, string $convertTo): string
    {
        if ($result === null) {
            return "Conversion de $convertFrom à $convertTo non supportée.";
        }

        return match ($convertFrom) {
            'px' => match ($convertTo) {
                'em', 'rem' => "{$value}px / {$this->rootFontSize} (Root Font Size) = {$result}{$convertTo}. La conversion implique de diviser la taille de police en pixels par la taille de police de base ({$this->rootFontSize}) pour obtenir la taille en em/rem.",
                '%' => "({$value}px / {$this->rootFontSize}) * 100 = {$result}{$convertTo}. La conversion implique de diviser la taille de police en pixels par la taille de police de base ({$this->rootFontSize}) pour obtenir la taille en pourcentage.",
                default => "",
            },
            'em', 'rem' => match ($convertTo) {
                'px' => "{$value}{$convertFrom} * {$this->rootFontSize} = {$result}{$convertTo}. La conversion implique de multiplier la taille de police en em/rem par la taille de police de base ({$this->rootFontSize}) pour obtenir la taille en pixels.",
                '%' => "{$value}{$convertFrom} * 100 = {$result}{$convertTo}. La conversion implique de multiplier la taille de police en em/rem par 100 pour obtenir la taille en pourcentage.",
                default => "",
            },
            '%' => match ($convertTo) {
                'px' => "({$value}% / 100) * {$this->rootFontSize} = {$result}{$convertTo}. La conversion implique de diviser la taille de police en pourcentage par 100 pour obtenir la taille en pixels.",
                'em', 'rem' => "({$value}% / 100) = {$result}{$convertTo}. La conversion implique de diviser la taille de police en pourcentage par 100 pour obtenir la taille en em/rem.",
                default => "",
            },
            default => "",
        };
    }

    /**
     * Description: Génère une description détaillée pour une conversion donnée.
     * @param string $convertFrom
     * @param string $convertTo
     * @return string
     */
    public function generateDescription(string $convertFrom, string $convertTo): string
    {
        return match ($convertFrom) {
            'px' => match ($convertTo) {
                'em', 'rem' => "Pour convertir des pixels (px) en em/rem, utilisez la formule : \\( \\frac{px}{" . $this->rootFontSize . "} = em/rem \\).",
                '%' => "Pour convertir des pixels (px) en pourcentage (%), utilisez la formule : \\( \\frac{px}{" . $this->rootFontSize . "} \\times 100 = \% \\).",
                'px' => sprintf("La conversion de \\( %s \\rightarrow %s \\) n'est pas nécessaire car les unités sont identiques. La taille de police reste la même.", $convertFrom, $convertTo),
                default => ""
            },
            'rem', 'em' => match ($convertTo) {
                'px' => "Pour convertir des rem/em en pixels (px), utilisez la formule : \\( rem/em \\times " . $this->rootFontSize . " = px \\).",
                '%' => "Pour convertir des rem/em en pourcentage (%), utilisez la formule : \\( rem/em \\times 100 = \% \\).",
                'rem', 'em' => sprintf("La conversion de \\( %s \\rightarrow %s \\) n'est pas nécessaire car les unités sont identiques. La taille de police reste la même.", $convertFrom, $convertTo),
                default => ""
            },
            '%' => match ($convertTo) {
                'px' => "Pour convertir un pourcentage (%) en pixels (px), utilisez la formule : \\( \\frac{\%}{100} \\times " . $this->rootFontSize . " = px \\).",
                'rem', 'em' => "Pour convertir un pourcentage (%) en rem/em, utilisez la formule : \\( \\frac{\%}{100} = rem/em \\).",
                '%' => sprintf("La conversion de \\( %s \\rightarrow %s \\) n'est pas nécessaire car les unités sont identiques. La taille de police reste la même.", $convertFrom, $convertTo),
                default => ""
            },
            default => ""
        };
    }
}
