<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 12:49
 * To change this template use File | Settings | File Templates.
 */

require_once('lib/func.php');
require_once('lib/func_raytrace.php');
autoload();

$width = 640;
$height = 400;

$image = imagecreatetruecolor($width,$height);

$scene = new Scene(
	new Output($width,$height),
	new Camera(
		new V3(0.0, -0.5, 0.0),
		new V3(-1.3, 1.0, 1.0),
		new V3(1.3, 1.0, 1.0),
		new V3(-1.3, 1.0, -1.0)
	),
	array(
//            // glowing sphere
//            new Body(new Sphere(new V3(0.0, 3.0, 0.0), 0.5), new Material(new V3(0.9, 0.9, 0.9), new V3(0.1, 1.0, 0.1))),
//            // glass sphere
//            new Body(new Sphere(new V3(1.0, 2.0, 0.0), 0.5), new Material_Glass(new V3(1.00, 1.00, 1.00), 1.5, 0.1)),
//            // chrome sphere
//            new Body(new Sphere(new V3(-1.1, 2.8, 0.0), 0.5), new Material_Chrome(new V3(0.8, 0.8, 0.8))),
//            // back
//            new Body(new Sphere(new V3(0.0, 10e6, 0.0), 10e6-4.5), new Material(new V3(0.9, 0.9, 0.9))),
//            // top light, the emmision should be close to that of warm sunlight (~5400k)
//            new Body(new Sphere(new V3(0.0, 0.0, 10e6), 10e6-2.5), new Material(new V3(0.0, 0.0, 0.0), new V3(1.6, 1.47, 1.29))),

            // glowing sphere
            new Body(new Sphere(new V3(0.0, 3.0, 0.0), 0.5), new Material(new V3(0.9, 0.9, 0.9), new V3(0.1, 0.9, 0.1))),

            // glass sphere
            new Body(new Sphere(new V3(1.0, 2.0, 0.0), 0.5), new Material_Glass(new V3(1.00, 1.00, 1.00), 1.5, 0.1)),
            // chrome sphere
            new Body(new Sphere(new V3(-1.1, 2.8, 0.0), 0.5), new Material_Chrome(new V3(0.8, 0.8, 0.8))),
            // floor
            new Body(new Sphere(new V3(0.0, 3.5, -10e6), 10e6-0.5), new Material(new V3(0.9, 0.9, 0.9))),
            // back
            new Body(new Sphere(new V3(0.0, 10e6, 0.0), 10e6-4.5), new Material(new V3(0.9, 0.9, 0.9))),
            // left
            new Body(new Sphere(new V3(-10e6, 3.5, 0.0), 10e6-1.9), new Material(new V3(0.9, 0.5, 0.5))),
            // right
            new Body(new Sphere(new V3(10e6, 3.5, 0.0), 10e6-1.9), new Material(new V3(0.5, 0.5, 0.9))),

            // top light, the emmision should be close to that of warm sunlight (~5400k)
            new Body(new Sphere(new V3(0.0, 0.0, 10e6), 10e6-2.5), new Material(new V3(0.0, 0.0, 0.0), new V3(1.6, 1.47, 1.29))),

            // front
            new Body(new Sphere(new V3(0.0, -10e6, 0.0), 10e6-2.5), new Material(new V3(0.9, 0.9, 0.9))),

	)
);

if(file_exists("out/cache.serial"))
{
	$tmp = unserialize(file_get_contents('out/cache.serial'));

	$i = $tmp['i'];
	$buffer = $tmp['buffer'];

	unset($tmp);
}
else
{
	$buffer = array();
	for($y=0;$y<$height;$y++)
	{
		for($x=0;$x<$width;$x++)
		{
			$buffer[$y][$x] = new V3(0,0,0);
		}
	}
	$i = 0;
}

$renderer = new Renderer($scene);
while(++$i)
{
	echo "Iteration $i:\n";
	$renderer->iterate();

	$max = 0;

	for($y=0;$y<$height;$y++)
	{
		for($x=0;$x<$width;$x++)
		{
			$vector = $buffer[$y][$x] = $buffer[$y][$x]->add($renderer->buffer[$y][$x]);
			$max = max($max, $vector->x);
			$max = max($max, $vector->y);
			$max = max($max, $vector->z);
		}
	}

	echo "MAX={$max}".PHP_EOL;
	$scale = 250/$i;

	for($y=0;$y<$height;$y++)
	{
		for($x=0;$x<$width;$x++)
		{

//echo "AAA=".($buffer[$y][$x]->x).PHP_EOL;


			$color = imagecolorallocate(
				$image,
				min(255,$buffer[$y][$x]->x * $scale),
				min(255,$buffer[$y][$x]->y * $scale),
				min(255,$buffer[$y][$x]->z * $scale)
			);

			imagesetpixel($image,$x,$y,$color);
		}
	}
	imagepng($image,'out/out-'.str_pad($i, 5, "00000", STR_PAD_LEFT).'.png');

	$renderer->clearBuffer();

	file_put_contents('out/cache.serial',serialize(['i'=>$i,'buffer'=>$buffer]));
}




