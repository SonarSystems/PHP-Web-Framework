<?php

namespace Sonar;

require_once( "Path.php" );

class Redirect
{
    // Redirect the user to page/view
	public static function To( $location = null )
	{
		if ( $location )
		{   
			header( "Location: " . \Sonar\Path::To( $location ) );

			exit( );
		}
	}
}