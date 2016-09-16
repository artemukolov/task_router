<?php

namespace Ukolov\Router;

/**
 * Class Router.
 *
 * Instanses of this classes can return optimal route by points array
 *
 * @package Ukolov
 */

class Router
{
	/**
    * @var parsedRoutes
    */
    private $parsedRoutes;


    /**
    */
    public function __construct()
    {
        $this->parsedRoutes = [];
    }

	/**
    * Parsing routes for associative array
    *
    * @param $unparsedRoutes
    *  
    */
	
	protected function parseRoutes($unparsedRoutes) 
	{
		foreach ($unparsedRoutes as $row) {
			if (!array_key_exists($row[0], $this->parsedRoutes)){
				$this->parsedRoutes[$row[0]] = [];
			}
			if (!array_key_exists($row[1], $this->parsedRoutes)){
				$this->parsedRoutes[$row[1]] = [];
			}
			$this->parsedRoutes[$row[0]][$row[1]] = $row[2];
			$this->parsedRoutes[$row[1]][$row[0]] = $row[2];
		}
	}
    /**
    * Recursive function for searching optimal route from point to point
    *
    * @param $point1
    *  
    * @param $point2
    *  
    * @param $passed
    *  
    * @return array of 3 elements: 
		1. price (integer)
		2. route (array)
		3. detectDestination (boolean)
    */
	
	protected function getOptimalRoute($point1, $point2, $passed = []) 
	{
		$finalResponsePrice = false;
		$finalResponseRoute = [];
		$detectDestination = false;
		foreach ($this->parsedRoutes[$point1] as $destination => $value) {
			if (in_array($destination, $passed)){
				continue;
			}
			$responsePrice = $value;
			$responseRoute = [$destination];
			if ($destination == $point2){
				$detectDestination = true;
			} else {
				$array = $this->getOptimalRoute($destination, $point2, array_merge($passed, [$point1]));
				if ($array['detectDestination']){
					$responsePrice += $array['price'];
					$responseRoute = array_merge($responseRoute, $array['route']);
					$detectDestination = true;
				}
			}
			if (($detectDestination) and (($finalResponsePrice > $responsePrice) or ($finalResponsePrice === false))){
				$finalResponsePrice = $responsePrice;
				$finalResponseRoute = $responseRoute;
			}
		}
		$response = [
			"price" => $finalResponsePrice,
			"route" => $finalResponseRoute,
			"detectDestination" => $detectDestination
		];
		return $response;
	}

    /**
    * Get optimal route by points array
    *
    * @param $point1
    *  
    * @param $point2
    *  
    * @param $routes
    *  
    * @return array of 3 elements: 
		1. error value (boolean)
		2. route (array). Empty if first element is true
		3. route price. 0 if first element is true
    */
	
	public function getRoute($point1, $point2, $routes) 
	{
		$this->parseRoutes($routes);
		$optimalRoute = $this->getOptimalRoute($point1, $point2);
		return [
			!$optimalRoute['detectDestination'],
			$optimalRoute['route'],
			$optimalRoute['price']
		];
	}
}