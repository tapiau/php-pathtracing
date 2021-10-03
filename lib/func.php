<?php

declare(ticks = 1);
define('__ROOT',realpath(dirname(__FILE__).'/..'));
ini_set('include_path',ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__));

function object($array=array())
{
	$obj = ((object) NULL);
	foreach($array as $key=>$value)
	{
		if(is_array($value))
		{
			$value = object($value);
		}
		$obj->$key = $value;
	}
	return $obj;
}
function printr($tab)
{
	$dbg = debug_backtrace();
	$time = now();
	$pid = getmypid();
	echo "### {$pid} :: {$time} :: {$dbg[0]['file']}:{$dbg[0]['line']} ###\n";
	print_r($tab);
	echo "\n";
}
function autoload()
{
//    ini_set('unserialize_callback_func','spl_autoload_call');
//
         spl_autoload_register("_autoload");

//	function __autoload($class_name)
//	{
//		$filename = str_replace('_','/',$class_name) . '.php';
//
//		$found = false;
//		foreach(explode(PATH_SEPARATOR,ini_get('include_path')) as $path)
//		{
//			if(file_exists($path.'/'.$filename))
//			{
//				$found = $path.'/'.$filename;
//			}
//		}
//		
//		if(!$found)
//		{
//			printr($filename);
//			$dbg = debug_backtrace();
//			printr($dbg);
//			
//			throw new Exception('Class '.$class_name.' not found');
//		}
//
//		require_once $found;
//	}
}
function _autoload($class_name)
{
    $filename = str_replace('_','/',$class_name) . '.php';

    $found = false;
    foreach(explode(PATH_SEPARATOR,ini_get('include_path')) as $path)
    {
        if(file_exists($path.'/'.$filename))
        {
            $found = $path.'/'.$filename;
        }
    }

    if(!$found)
    {
//			printr($filename);
//			$dbg = debug_backtrace();
//			printr($dbg);

        throw new Exception('Class '.$class_name.' not found');
    }

    require_once $found;
}
//function is_iterable($obj,$interface=false)
//{
//	return 
//		is_object($obj) ?
//			$interface ?
//				array_search('Iterator',class_implements($obj))!==false
//				:
//				true
//			:
//			is_array($obj)
//	;
//}
function array_qsort(&$array, $column=0, $order=SORT_ASC)
{
	$dst = array();
	$sort = array();

	foreach($array as $key => $value)
	{
		if(is_array($value))
		{
			$sort[$key] = $value[$column];
		}
		else
		{
			$sort[$key] = $value->$column;
		}
	}
	if($order == SORT_ASC)
	{
		asort($sort);
	}
	else
	{
		arsort($sort);
	}

	foreach($sort as $key=>$value)
	{
		$dst[(string)$key] = $array[$key];
	}
	$array = $dst;
}
function now()
{
	return date('Y-m-d H:i:s');
}
function str_ends($haystack,$needle)
{
	return substr($haystack,-strlen($needle))==$needle;
}
function str_begins($haystack,$needle)
{
	return substr($haystack,0,strlen($needle))==$needle;
}
//function str_contains($haystack,$needle)
//{
//	return strpos($haystack,$needle)!==false;
//}
//function backtrace()
//{
//	return array_map(
//		function($row){unset($row['object']); return $row;},
//		debug_backtrace()
//	);
//}
function not_empty($row)
{
	return !empty($row);
}
function saveSerial($filename,$data)
{
	$filename = __ROOT.'/tmp/'.$filename.'.phpserial';
	file_put_contents($filename,serialize($data));
}
function array_merge_recursive_overwrite($arr1, $arr2)
{
	foreach($arr2 as $key=>$value)
	{
		if(array_key_exists($key, $arr1) && is_array($value))
		{
			$arr1[$key] = array_merge_recursive_overwrite($arr1[$key], $arr2[$key]);
		}
		else
		{
			if(!empty($value))
			{
				$arr1[$key] = $value;
			}
		}
	}

	return $arr1;
}
//function path2array($path,$data=null)
//{
//	return array_reduce(
//		array_reverse(explode('/',trim($path,'/'))),
//		function($sum,$sub)
//		{
//			return array($sub=>$sum);
//		},
//		$data
//	);
//}
function parseCLI($argv,$inputs=array())
{
        $ret = array('param'=>array(),'flag'=>array(),'input'=>array());
        $n=false;

        foreach($argv as $arg)
        {
                // named param
                if(substr($arg,0,2)==='--')
                {
                        $value = preg_split( '/[= ]/', $arg, 2 );
                        $param = substr( array_shift($value), 2 );
                        $value = join($value);

                        $ret['param'][$param] = !empty($value) ? $value : true;
                        continue;
                }
                // flag
                if(substr($arg,0,1)==='-')
                {
                        for($i=1;isset($arg[$i]);$i++)
                        {
                                $flag = substr($arg,$i,1);
                                if($flag!=='-')
                                {
                                        $ret['flag'][$flag]=(substr($arg,$i+1,1)=='-')?false:true;
                                }
                        }
                        continue;
                }
                if(substr($arg,0,1)==='+')
                {
                        $flag = substr($arg,1,1);
                        $ret['flag'][$flag]=true;
                        continue;
                }

                if(count($inputs)&&$n)
                {
                        $ret['input'][array_shift($inputs)]=$arg;
                }
                else
                {
                        $ret['input'][]=$arg;
                }
                $n=true;
        }

        return $ret;
}



