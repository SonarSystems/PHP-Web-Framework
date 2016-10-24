<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Misc.php" );

class Path
{
    public static function to( $location = null )
    {
        return Misc::prependRoot( $location );
    }
}

?>