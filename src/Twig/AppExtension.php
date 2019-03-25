<?php

namespace App\Twig;

use App\Entity\LikeNotification;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\Extension\GlobalsInterface;

/**
 * AppExtension
 */
class AppExtension extends AbstractExtension implements GlobalsInterface
{
	/**
	* @var string
	*/
	private $locale;

	function __construct(string $locale)
	{
		$this->locale = $locale;
	}

	public function getFilters()
	{
		return [
			new TwigFilter('price', [$this, 'priceFilter'])
		];
	}

	public function priceFilter($number)
	{
		return '$'.number_format($number, 2, '.', ',');
	}

	public function getGlobals()
	{
		return [
			'locale' => $this->locale
		];
	}

	public function getTests()
	{
		return [
			new \Twig_SimpleTest(
				'like',
				function ($obj){
					return $obj instanceof LikeNotification;
				})
		];
	}
}