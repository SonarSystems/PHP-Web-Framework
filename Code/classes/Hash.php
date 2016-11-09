<?php

namespace Sonar;

class Hash
{
	public static function Make( $string, $salt = "" )
	{
		return hash( "sha256", $string . $salt );
	}

	public static function Salt( $length )
	{
		return bin2hex( random_bytes( $length ) );
	}

	public static function Unique( )
	{
		return self::Make( uniqid( ) );
	}
}