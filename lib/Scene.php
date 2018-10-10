<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 15:02
 * To change this template use File | Settings | File Templates.
 */
 
class Scene {
	/**
	 * @var Output
	 */
	public $output;
	/**
	 * @var Camera
	 */
	public $camera;
	/**
	 * @var Body[]
	 */
	public $objects;

	public function __construct($output,$camera,$objects)
	{
		$this->output = $output;
		$this->camera = $camera;
		$this->objects = $objects;
	}
}

