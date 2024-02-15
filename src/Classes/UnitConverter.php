<?php

namespace App\Classes;

use InvalidArgumentException;

/**
 * Auteur : Paterne G.G.
 * Description : Classe pour convertir une taille de police d'une unité à une autre
 * Contact : it.devwebm@gmail.com
 * Site Web : https://gnpinformatique.fr/
 * Licence : MIT
 * Version : 1.0
 * Les unités prises en charge sont px, rem, em et %, et la taille de police de base est 16px par défaut
 */

class UnitConverter
{
    private float $rootFontSize; // Taille de police de base en pixels

    public function __construct(float $rootFontSize = 16)
    {
        $this->rootFontSize = $rootFontSize;
    }

    public function performConversion(float $value, string $convertFrom, string $convertTo): array
    {
        if (!$this->isValidUnit($convertFrom) || !$this->isValidUnit($convertTo)) {
            throw new InvalidArgumentException("Unités fournies pour la conversion invalides.");
        }

        $result = match ($convertFrom) {
            'px' => match ($convertTo) {
                'em', 'rem'  => $value / $this->rootFontSize,
                '%'           => ($value / $this->rootFontSize) * 100,
                default       => throw new InvalidArgumentException("La conversion de px à $convertTo n'est pas prise en charge.")
            },
            '%' => match ($convertTo) {
                'px'         => ($value / 100) * $this->rootFontSize,
                'rem', 'em'  => $value / 100,
                default      => throw new InvalidArgumentException("La conversion de % à $convertTo n'est pas prise en charge.")
            },
            'em', 'rem' => match ($convertTo) {
                'px'         => $value * $this->rootFontSize,
                '%'          => $value * 100,
                'rem', 'em'  => $value,
                default      => throw new InvalidArgumentException("La conversion de $convertFrom à $convertTo n'est pas prise en charge.")
            },
            default => throw new InvalidArgumentException("La conversion de $convertFrom à $convertTo n'est pas prise en charge.")
        };

        $conversionMethod = $this->generateConversionMethod($value, $convertFrom, $result, $convertTo);
        return [$result, $conversionMethod];
    }


    private function isValidUnit(string $unit): bool
    {
        return in_array($unit, ['px', 'em', 'rem', '%']);
    }

    private function generateConversionMethod(float $value, string $convertFrom, float $result, string $convertTo): string
    {
        if ($convertFrom === $convertTo) {
            return "{$value}{$convertFrom} = {$result}{$convertTo} (Pas de conversion nécessaire)";
        }

        return match ($convertFrom) {
            'px' => match ($convertTo) {
                'em', 'rem'     => "{$value}{$convertFrom} / {$this->rootFontSize} = {$result}{$convertTo}",
                '%'             => "({$value}{$convertFrom} / {$this->rootFontSize}) * 100 = {$result}{$convertTo}",
            },
            '%' => match ($convertTo) {
                'px'             => "({$value}{$convertFrom} / 100) * {$this->rootFontSize} = {$result}{$convertTo}",
                'rem', 'em'      => "{$value}{$convertFrom} / 100 = {$result}{$convertTo}",
            },
            'em', 'rem' => match ($convertTo) {
                'px'             => "{$value}{$convertFrom} * {$this->rootFontSize} = {$result}{$convertTo}",
                '%'              => "{$value}{$convertFrom} * 100 = {$result}{$convertTo}",
            },
        };
    }

    public function generateDescription(string $convertFrom, string $convertTo): string
    {
        return match ($convertFrom) {
            'px' => match ($convertTo) {
                'em', 'rem' => "Pour convertir pixels (px) en em/rem, utilisez la formule : \\( \\frac{px}{" . $this->rootFontSize . "} = em/rem \\).",
                '%'         => "Pour convertir pixels (px) en pourcentage (%), utilisez la formule : \\( \\frac{px}{" . $this->rootFontSize . "} \\times 100 = \% \\).",
                default     => "Cette conversion n'est pas applicable."
            },
            'rem', 'em' => match ($convertTo) {
                'px'     => "Pour convertir rem/em en pixels (px), utilisez la formule : \\( rem/em \\times " . $this->rootFontSize . " = px \\).",
                '%'      => "Pour convertir rem/em en pourcentage (%), utilisez la formule : \\( rem/em \\times 100 = \% \\).",
                'rem', 'em' => "Aucune conversion nécessaire, la taille de police reste la même.",
                default  => "Cette conversion n'est pas applicable."
            },
            '%' => match ($convertTo) {
                'px'     => "Pour convertir pourcentage (%) en pixels (px), utilisez la formule : \\( \\frac{\%}{100} \\times " . $this->rootFontSize . " = px \\).",
                'rem', 'em' => "Pour convertir pourcentage (%) en rem/em, utilisez la formule : \\( \\frac{\%}{100} = rem/em \\).",
                default => "Cette conversion n'est pas applicable."
            },
            default => "Cette conversion n'est pas applicable."
        };
    }

}

