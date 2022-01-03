<?php

namespace App\Service;

class GenerationCodeCommande
{
	public function generate(): string
	{
		return strtoupper(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890'), 0, 10));
	}
}