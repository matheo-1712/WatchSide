<?php

namespace App\Service;

use App\Entity\Film;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PricingService
{
    private array $surgeRules;
    private array $specialDates;
    private array $specialRanges;

    public function __construct(ParameterBagInterface $params)
    {
        $this->surgeRules = $params->get('app.pricing.surge_rules');
        $this->specialDates = $params->get('app.pricing.special_dates');
        $this->specialRanges = $params->has('app.pricing.special_ranges') ? $params->get('app.pricing.special_ranges') : [];
    }

    public function calculatePrice(Film $film): float
    {
        if (!$film->getPrixDefault()) {
            return 0.0;
        }

        $multiplier = $this->getCurrentMultiplier();
        return round($film->getPrixDefault() * $multiplier, 2);
    }

    public function getCurrentMultiplier(): float
    {
        $today = new \DateTime();
        $today->setTime(0, 0, 0);

        // On vérifie les plages de dates spéciales (priorité la plus haute)
        foreach ($this->specialRanges as $range) {
            $start = new \DateTime($range['start']);
            $end = new \DateTime($range['end']);

            if ($today >= $start && $today <= $end) {
                return $range['multiplier'];
            }
        }

        $currentMonth = (int) $today->format('n');
        $currentDay = (int) $today->format('j');
        $currentWeekDay = (int) $today->format('N');

        // On vérifie les dates spéciales
        foreach ($this->specialDates as $rule) {
            if ($rule['month'] === $currentMonth && $rule['day'] === $currentDay) {
                return $rule['multiplier'];
            }
        }

        // On vérifie les jours spéciaux
        foreach ($this->surgeRules as $rule) {
            if ($rule['day'] === $currentWeekDay) {
                return $rule['multiplier'];
            }
        }

        return 1.0;
    }

    public function getSurgeLabel(): ?string
    {
        $today = new \DateTime();
        $today->setTime(0, 0, 0);

        foreach ($this->specialRanges as $range) {
            $start = new \DateTime($range['start']);
            $end = new \DateTime($range['end']);

            if ($today >= $start && $today <= $end) {
                return $range['label'];
            }
        }

        $currentMonth = (int) $today->format('n');
        $currentDay = (int) $today->format('j');
        $currentWeekDay = (int) $today->format('N');

        foreach ($this->specialDates as $rule) {
            if ($rule['month'] === $currentMonth && $rule['day'] === $currentDay) {
                return $rule['label']; // e.g., "Star Wars Day"
            }
        }

        foreach ($this->surgeRules as $rule) {
            if ($rule['day'] === $currentWeekDay) {
                return $rule['label']; // e.g., "Dimanche"
            }
        }

        return null;
    }
}
