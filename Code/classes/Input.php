<?php

namespace Sonar;

class Input
{
    public static function exists( $type )
    {
        switch ( strtolower( trim ( $type ) ) )
        {
            case "post":
                return ( !empty( $_POST ) ) ? true : false;
                    
                break;
                
            case "get":
                return ( !empty( $_GET ) ) ? true : false;
                    
                break;
                
            default:
                return false;
                
                break;
        }
    }
    
    public static function get( $item, $type )
    {
        if ( isset( $type[$item] ) )
        {
            return $type[$item];
        }
        else if ( isset( $type[$item] ) )
        {
            return $type[$item];
        }
        
        return "";
    }
}

?>