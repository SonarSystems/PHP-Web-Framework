<?php

namespace Sonar;

class Session
{
    // Check if a session exists
    public static function Exists( $name )
    {
        return ( isset( $_SESSION[$name] ) ) ? true : false;
    }
    
    // Create a session
    public static function Put( $name, $value )
    {
        return $_SESSION[$name] = $value;
    }
    
    // Get data for a session
    public static function Get( $name )
    {
        return $_SESSION[$name];
    }
    
    // Delete a session
    public static function Delete( $name )
    {
        if ( self::Exists( $name ) )
        {
            unset( $_SESSION[$name] );
        }
    }
    
    // Store message in a session to be retrieved from a different page
    public static function Flash( $name, $string = '' )
    {
        if ( self::Exists( $name ) )
        {
            $session = self::Get( $name );

            self::Delete( $name );

            return $session;
        }
        else
        {
            self::Put( $name, $string );
        }
        
        return "";
    }
}