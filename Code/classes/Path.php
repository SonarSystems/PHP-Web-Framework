<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Misc.php" );

class Path
{
    public static function PrependRoot( $location = null )
    {
        // get the root directory to modify
        $path = Config::get( 'website/root' );

        // check if the root has a / at the end of the script name
        if ( "/" !== substr( $path, strlen( $path ) - 1, 1 ) )
        {
            $path .= "/";
        }
        
        $location = $path . $location;
        
        return $location;
    }
    
    public static function To( $location = null )
    {
        return self::PrependRoot( $location );
    }
}

?>