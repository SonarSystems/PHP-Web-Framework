<?php

namespace Sonar;

class Session
{
    public static function Exists( $name )
    {
        return ( isset( $_SESSION[$name] ) ) ? true : false;
    }
    
    public static function Put( $name, $value )
    {
        return $_SESSION[$name] = $value;
    }
    
    public static function Get( $name )
    {
        return $_SESSION[$name];
    }
    
    public static function Delete( $name )
    {
        if ( self::Exists( $name ) )
        {
            unset( $_SESSION[$name] );
        }
    }
    
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