<?php

namespace App\Twig;

use App\Entity\Film;
use App\Service\PricingService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PricingExtension extends AbstractExtension
{
    private PricingService $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('dynamic_price', [$this, 'getDynamicPrice']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('surge_label', [$this, 'getSurgeLabel']),
        ];
    }

    public function getDynamicPrice(Film $film): float
    {
        return $this->pricingService->calculatePrice($film);
    }

    public function getSurgeLabel(): ?string
    {
        return $this->pricingService->getSurgeLabel();
    }
}
