<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:12
 * To change $this template use File | Settings | File Templates.
 */
 
class V3 {
	public $x;
	public $y;
	public $z;

	public function __construct($x,$y,$z)
	{
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
	}

	public function add(V3 $v)
	{
		return new V3(
			$this->x + $v->x,
			$this->y + $v->y,
			$this->z + $v->z
		);
	}
	public function iadd(V3 $v)
	{
		$this->x += $v->x;
		$this->y += $v->y;
		$this->z += $v->z;
	}
	public function sub(V3 $v)
	{
		return new V3(
			$this->x - $v->x,
			$this->y - $v->y,
			$this->z - $v->z
		);
	}
	public function mul(V3 $v)
	{
		return new V3(
			$this->x * $v->x,
			$this->y * $v->y,
			$this->z * $v->z
		);
	}
	public function div(V3 $v)
	{
		return new V3(
			$this->x / $v->x,
			$this->y / $v->y,
			$this->z / $v->z
		);
	}
	public function muls($s)
	{
		return new V3(
			$this->x * $s,
			$this->y * $s,
			$this->z * $s
		);
	}
	public function divs($s)
	{
		return new V3(
			$this->x / $s,
			$this->y / $s,
			$this->z / $s
		);
	}
	public function dot(V3 $v)
	{
		return $this->x * $v->x
		       + $this->y * $v->y
		       + $this->z * $v->z
		;
	}
	public function normalize()
	{
		return $this->divs(sqrt($this->dot($this)));
	}
}
