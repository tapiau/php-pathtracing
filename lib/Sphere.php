<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:28
 * To change this template use File | Settings | File Templates.
 */
 
class Sphere extends Shape
{
	/**
	 * @var V3
	 */
	public $center;
	/**
	 * @var float
	 */
	public $radius;
	/**
	 * @var float
	 */
	public $radius2;

	public function __construct(V3 $center,$radius)
	{
		$this->center = $center;
		$this->radius = $radius;
		$this->radius2 = $radius*$radius;
	}
	public function intersect(Ray $ray)
	{
		$distance = $ray->origin->sub($this->center);
		$b = $distance->dot($ray->direction);
		$c = $distance->dot($distance) - $this->radius2;
		$d = $b*$b - $c;

		return $d>0 ? -$b - sqrt($d) : -1;
	}
	public function getNormal(V3 $point)
	{
		return $point->sub($this->center)->normalize();
	}
}
