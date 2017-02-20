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
            if ( is_numeric( $location ) )
            {
                switch( $location )
                {
                    case 404:
                        header( "HTTP/1.0 404 Not Found" );
                        include( "../public/errors/404.php" );
                        exit( );
                        
                        break;
                }
            }
            
			header( "Location: " . \Sonar\Path::To( $location ) );

			exit( );
		}
	}
}