<?php

namespace Sonar;

class Cookie
{
    // Check if a cookie exists
	public static function Exists( $name )
	{
		return ( isset( $_COOKIE[$name] ) ) ? true : false;
	}

    // Get a cookies data
	public static function Get( $name )
	{
		return $_COOKIE[$name];
	}

    // Set a cookie
	public static function Put( $name, $value, $expiry )
	{
		if ( setcookie( $name, $value, time( ) + $expiry, "/", null, null, true ) )
		{
			return true;
		}

		return false;
	}

    // Delete a cookie
	public static function Delete( $name )
	{
		self::Put( $name, "", time( ) - 1 );
	}
}