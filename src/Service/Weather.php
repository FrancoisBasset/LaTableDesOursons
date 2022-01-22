<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Weather
{
	private $temperature;
	private $icon;

	public function __construct(string $apiKey, HttpClientInterface $client)
	{
		$response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=Chamonix&appid='.$apiKey.'&units=metric');

		$this->temperature = floor(json_decode($response->getContent())->main->temp).'°C';
		$this->icon = 'https://openweathermap.org/img/wn/'.json_decode($response->getContent())->weather[0]->icon.'.png';
	}

	public function getTemperature()
	{
		return $this->temperature;
	}

	public function getIcon()
	{
		return $this->icon;
	}
}