<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:37
 * To change this template use File | Settings | File Templates.
 */
 
class Material {
	public $color;
	public $emission;

	public function __construct($color, $emission = null)
	{
		$this->color = $color;
		$this->emission = $emission==null ? new V3(0,0,0) : $emission;
	}
	/**
	 * @param Ray $ray
	 * @param $normal
	 * @return V3
	 */
	public function bounce(Ray $ray, V3 $normal)
	{
		return getRandomNormalInHemisphere($normal);
	}
}


