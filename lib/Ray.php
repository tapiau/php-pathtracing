<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:30
 * To change this template use File | Settings | File Templates.
 */
 
class Ray {
	/**
	 * @var V3
	 */
	public $origin;
	/**
	 * @var V3
	 */
	public $direction;

	public function __construct($origin,$direction)
	{
		$this->origin = $origin;
		$this->direction = $direction;
	}
}
