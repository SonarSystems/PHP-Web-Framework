<?php

namespace Sonar;

class Hash
{
    // Make a sha256 hash
	public static function Make( $string, $salt = "" )
	{
		return hash( "sha256", $string . $salt );
	}

    // Make a salt
	public static function Salt( $length )
	{
		return bin2hex( random_bytes( $length ) );
	}

    // Make a Unique ID sha256 hash
	public static function Unique( )
	{
		return self::Make( uniqid( ) );
	}
}