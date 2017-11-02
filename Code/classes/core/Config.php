<?php

namespace Sonar;

$GLOBALS['config'] = array( );

foreach ( glob( "../core/__CONFIGS/core/*.php" ) as $filename )
{
    require_once( $filename );

    $GLOBALS['config'][$name] = $array;
}

foreach ( glob( "../core/__CONFIGS/custom/*.php" ) as $filename )
{
    require_once( $filename );

    $GLOBALS['config'][$name] = $array;
}

class Config
{
    // Get configuration
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