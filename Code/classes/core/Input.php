<?php

namespace Sonar;

class Input
{
    // Check if any input has occured
    public static function Exists( $type )
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
    
    // Get any input data
    public static function Get( $item, $type )
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