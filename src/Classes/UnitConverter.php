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

    public function performConversion(float $value, string $convertFrom, string $convertTo): array
    {
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

    public function setRootFontSize(float $fontSize): void
    {
        $this->rootFontSize = $fontSize;
    }

    private function pxToOthers(float $value, string $convertTo): ?float
    {
        return match ($convertTo) {
            'em', 'rem' => $value / $this->rootFontSize,
            '%' => ($value / $this->rootFontSize) * 100,
            default => null,
        };
    }

    private function percentToOthers(float $value, string $convertTo): ?float
    {
        return match ($convertTo) {
            'px' => ($value / 100) * $this->rootFontSize,
            'rem', 'em' => $value / 100,
            default => null,
        };
    }

    private function relativeToOthers(float $value, string $convertFrom, string $convertTo): ?float
    {
        return match ($convertTo) {
            'px' => $value * $this->rootFontSize,
            '%' => $value * 100,
            'em', 'rem' => $value, // Pas de conversion nécessaire si les unités sont identiques
            default => null,
        };
    }

    private function isValidUnit(string $unit): bool
    {
        $validUnits = ['px' => true, 'em' => true, 'rem' => true, '%'=> true];
        return isset($validUnits[$unit]);
    }
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


    public function generateDescription(string $convertFrom, string $convertTo): string
    {
        return match ($convertFrom) {
            'px' => match ($convertTo) {
                'em', 'rem' => "Pour convertir des pixels (px) en em/rem, utilisez la formule : \\( \\frac{px}{" . $this->rootFontSize . "} = em/rem \\).",
                '%' => "Pour convertir des pixels (px) en pourcentage (%), utilisez la formule : \\( \\frac{px}{" . $this->rootFontSize . "} \\times 100 = \% \\).",
                default => "Cette conversion n'est pas applicable."
            },
            'rem', 'em' => match ($convertTo) {
                'px' => "Pour convertir des rem/em en pixels (px), utilisez la formule : \\( rem/em \\times " . $this->rootFontSize . " = px \\).",
                '%' => "Pour convertir des rem/em en pourcentage (%), utilisez la formule : \\( rem/em \\times 100 = \% \\).",
                'rem', 'em' => "Aucune conversion nécessaire, la taille de police reste la même.",
                default => "Cette conversion n'est pas applicable."
            },
            '%' => match ($convertTo) {
                'px' => "Pour convertir un pourcentage (%) en pixels (px), utilisez la formule : \\( \\frac{\%}{100} \\times " . $this->rootFontSize . " = px \\).",
                'rem', 'em' => "Pour convertir un pourcentage (%) en rem/em, utilisez la formule : \\( \\frac{\%}{100} = rem/em \\).",
                default => "Cette conversion n'est pas applicable."
            },
            default => "Cette conversion n'est pas applicable."
        };
    }
}
