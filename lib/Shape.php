<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 15:11
 * To change this template use File | Settings | File Templates.
 */
 
class Shape
{
	public function intersect(Ray $ray)
	{
		throw new Exception('No shape defined!');
	}
	public function getNormal(V3 $point)
	{
		throw new Exception('No shape defined!');
	}
}
