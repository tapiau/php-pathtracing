<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:52
 * To change this template use File | Settings | File Templates.
 */
 
class Body {
	/**
	 * @var Shape
	 */
	public $shape;
	/**
	 * @var Material
	 */
	public $material;

	public function __construct($shape,$material)
	{
		$this->shape = $shape;
		$this->material = $material;
	}
}
