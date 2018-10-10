<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zibi
 * Date: 21.10.11
 * Time: 14:39
 * To change this template use File | Settings | File Templates.
 */
 
/*
 * This is my crude way of generating random normals in a hemisphere.
 * In the first step I generate random vectors with components
 * from -1 to 1. As this introduces a bias I discard all the points
 * outside of the unit sphere. Now I've got a random normal vector.
 * The last step is to mirror the point if it is in the wrong hemisphere.
 */
function getRandomNormalInHemisphere(V3 $v)
{
    do
    {
        $v2 = new V3(random()*2.0-1.0, random()*2.0-1.0,  random()*2.0-1.0);
    } while($v2->dot($v2) > 1.0);

    // should only require about 1.9 iterations of average
    $v2 = $v2->normalize();

    // if the point is in the wrong hemisphere, mirror it
    if($v2->dot($v) < 0.0)
    {
        return $v2->muls(-1);
    }
    return $v2;
}

function random()
{
	return  mt_rand(1,10000000)/10000000;
}