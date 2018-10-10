<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 15:04
 * To change this template use File | Settings | File Templates.
 */
 
class Output
{
	public $width;
	public $height;

	public function __construct($width,$height)
	{
		$this->width = $width;
		$this->height = $height;
	}
}
