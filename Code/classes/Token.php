<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Session.php" );

class Token
{
    // Generate a Unique ID MD5 encryped token
    public static function Generate( )
    {
        return Session::Put( Config::Get( "session/tokenName" ), md5( uniqid( ) ) );
    }
    
    // Check if token matches created token
    public static function Check( $token )
    {
        $tokenName = Config::Get( "session/tokenName" );
        
        if ( Session::Exists( $tokenName ) && Session::Get( $tokenName ) === $token )
        {
            Session::Delete( $tokenName );
            
            return true;
        }
        
        return false;
    }
}