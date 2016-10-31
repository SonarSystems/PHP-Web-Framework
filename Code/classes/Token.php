<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Session.php" );

class Token
{
    public static function generate( )
    {
        return Session::put( Config::get( "session/tokenName" ), md5( uniqid( ) ) );
    }
    
    public static function check( $token )
    {
        $tokenName = Config::get( "session/tokenName" );
        
        if ( Session::exists( $tokenName ) && $token === Session::get( $tokenName ) )
        {
            Session::delete( $tokenName );
            
            return true;
        }
        
        return false;
    }
}