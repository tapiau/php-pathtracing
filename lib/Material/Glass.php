<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:44
 * To change this template use File | Settings | File Templates.
 */
 
class Material_Glass extends Material
{
	public $ior;
	public $reflection;

	public function __construct($color, $ior, $reflection)
	{
		parent::__construct($color);
		$this->ior = $ior;
		$this->reflection = $reflection;
	}
	public function bounce(Ray $ray,V3 $normal)
	{
		$theta1 = abs($ray->direction->dot($normal));
		if($theta1 >= 0.0)
		{
			$internalIndex = $this->ior;
			$externalIndex = 1.0;
		}
		else
		{
			$internalIndex = 1.0;
			$externalIndex = $this->ior;
		}
		$eta = $externalIndex/$internalIndex;
		$theta2 = sqrt(1.0 - ($eta * $eta) * (1.0 - ($theta1 * $theta1)));
		$rs = ($externalIndex * $theta1 - $internalIndex * $theta2) / ($externalIndex * $theta1 + $internalIndex * $theta2);
		$rp = ($internalIndex * $theta1 - $externalIndex * $theta2) / ($internalIndex * $theta1 + $externalIndex * $theta2);
		$reflectance = ($rs*$rs + $rp*$rp);

		// reflection
		if(random() < $reflectance+$this->reflection)
		{
			return $ray->direction->add($normal->muls($theta1*2.0));
		}
		// refraction
		return ($ray->direction->add($normal->muls($theta1))->muls($eta)->add($normal->muls(-$theta2)));
		//return ray.direction.muls(eta).sub(normal.muls(theta2-eta*theta1));
	}
}
