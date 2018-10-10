<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:21
 * To change this template use File | Settings | File Templates.
 */
 
class Camera {
	/**
	 * @var V3
	 */
	public $origin;
	/**
	 * @var V3
	 */
	public $topleft;
	/**
	 * @var V3
	 */
	public $topright;
	/**
	 * @var V3
	 */
	public $bottomleft;

	/**
	 * @var V3
	 */
	public $xd;
	/**
	 * @var V3
	 */
	public $yd;

	public function __construct(V3 $origin,V3 $topleft,V3 $topright,V3 $bottomleft)
	{
		$this->origin = $origin;
		$this->topleft = $topleft;
		$this->topright = $topright;
		$this->bottomleft = $bottomleft;

		$this->xd = $topright->sub($topleft);
		$this->yd = $bottomleft->sub($topleft);
	}
	public function getRay($x, $y)
	{
		// point on screen plane
		/**
		 * @var V3 $p
		 */
		$p = $this->topleft->add($this->xd->muls($x))->add($this->yd->muls($y));
		return new Ray(
			$this->origin,
			$p->sub($this->origin)->normalize()
		);
        }
}
