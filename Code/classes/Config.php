<?php

namespace Sonar;

$GLOBALS['config'] = array( );

foreach ( glob( "../core/__CONFIGS/*.php" ) as $filename )
{
    require_once( $filename );

    $GLOBALS['config'][$name] = $array;
}

class Config
{
	public static function Get( $path = null )
	{
		if ( $path )
		{
			$config = $GLOBALS['config'];
			$path = explode( '/', $path );

			foreach( $path as $bit )
			{
				if ( isset( $config[$bit] ) )
				{
					$config = $config[$bit];
				}
			}

			return $config;
		}

		return false;
	}
}