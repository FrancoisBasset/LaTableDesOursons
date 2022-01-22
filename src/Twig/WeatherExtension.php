<?php

namespace App\Twig;

use App\Service\Weather;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class WeatherExtension extends AbstractExtension
{
	private Weather $weather;

	public function __construct(Weather $weather)
	{
		$this->weather = $weather;
	}

    public function getFilters(): array
    {
        return [];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getTemperature', [$this, 'getTemperature']),
			new TwigFunction('getIcon', [$this, 'getIcon'])
        ];
    }

    public function getTemperature()
    {
        return $this->weather->getTemperature();
    }

	public function getIcon()
	{
		return $this->weather->getIcon();
	}
}
