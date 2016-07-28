<?php

/*
*   should be used for functions that are to be used from multiple classes
*   and have no obvious home :()
*/

class Misc
{
    public static function prependRoot( $location = null )
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
}

?>