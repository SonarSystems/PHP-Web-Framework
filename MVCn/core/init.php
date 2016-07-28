<?php

session_start( );

// require all the classes
foreach ( glob( "../classes/*.php" ) as $filename )
{
    require_once( $filename );
}

// require all the library files
require_once( "LIBS_TO_INCLUDE.php" );
require_once( "misc/BUILT_IN_LIBS.php" );
require_once( "FILES_TO_INCLUDE.php" );

if ( Cookie::exists( Config::get( "remember/cookieName" ) ) && !Session::exists( Config::get( "session/sessionName" ) ) )
{
	$hash = Cookie::get( Config::get( "remember/cookieName" ) );
    
    if ( Config::get( "mysql/enabled" ) )
    {
        $hashCheck = DB::getInstance( )->get( "users_sessions", array( "hash", "=", $hash ) );

        if ( $hashCheck->count( ) )
        {
            $user = new User( $hashCheck->first( )->user_id );

            $user->login( );
        }
    }
}

?>