<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:42
 * To change this template use File | Settings | File Templates.
 */
 
class Material_Chrome extends Material
{
	public function bounce(Ray $ray,V3 $normal)
	{
		$theta1 = abs($ray->direction->dot($normal));
		return $ray->direction->add($normal->muls($theta1*2.0));
	}
}
