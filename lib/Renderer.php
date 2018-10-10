<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:54
 * To change this template use File | Settings | File Templates.
 */
 
class Renderer {
	/**
	 * @var Scene
	 */
	public $scene;
	/**
	 * @var V3[][];
	 */
	public $buffer = array();

	public function __construct($scene)
	{
		$this->scene = $scene;
		for($y=0;$y<$scene->output->height;$y++)
		{
			for($x=0;$x<$scene->output->width;$x++)
			{
				$this->buffer[$y][$x] = new V3(0,0,0);
			}
		}
	}
	public function clearBuffer()
	{
		for($y=0;$y<$this->scene->output->height;$y++)
		{
			for($x=0;$x<$this->scene->output->width;$x++)
			{
				$this->buffer[$y][$x] = new V3(0,0,0);
			}
		}
	}
	public function iterate()
	{
		$scene = $this->scene;
		$w = $scene->output->width;
		$h = $scene->output->height;

		$by = 0;
		for($y = random()/$h,$ystep=1/$h;$y<0.99999;$y+=$ystep)
		{
			$bx = 0;
			for($x = random()/$w,$xstep=1/$w;$x<0.99999;$x+=$xstep)
			{
				$ray = $scene->camera->getRay($x,$y);
				$color = $this->trace($ray,0);
				$this->buffer[$by][$bx]->iadd($color);
				echo "\r $by :: $bx  ";
				$bx++;
			}
			$by++;
		}
		echo "\n";
	}
	public function trace(Ray $ray,$n)
	{
		$mint = 9999999;

		if($n > 8)
		{
			return new V3(0,0,0);
		}
		/**
		 * @var Body
		 */
		$hit = null;

		foreach($this->scene->objects as $body)
		{
			$t = $body->shape->intersect($ray);
			if($t > 0 && $t<=$mint)
			{
				$mint = $t;
				$hit = $body;
			}
		}

		if($hit === null)
		{
			return new V3(0,0,0);
		}

		$point = $ray->origin->add($ray->direction->muls($mint));
		$normal = $hit->shape->getNormal($point);

		$direction = $hit->material->bounce($ray,$normal);

		if($direction->dot($ray->direction) > 0)
		{
			// if the ray is refracted move the intersection point a bit in
			$point = $ray->origin->add($ray->direction->muls($mint*1.0000001));
		}
		else
		{
			// otherwise move it out to prevent problems with floating point accuracy
			$point = $ray->origin->add($ray->direction->muls($mint*0.99999999));
		}

		$newray = new Ray($point,$direction);

		return $this->trace($newray, $n+1)
			->mul($hit->material->color)
			->add($hit->material->emission)
		;
	}
}
