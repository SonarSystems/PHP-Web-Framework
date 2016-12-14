<?php

require_once( "../classes/Config.php" );

if ( !Sonar\Config::get( "website/debug" ) )
{
    error_reporting( 0 );
}
else
{
    error_reporting( E_ALL );
}

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
require_once( "../libs/GoogleReCAPTCHA/autoload.php" );
require_once( "../libs/hybridauth/hybridauth/Hybrid/Auth.php" );

if ( Sonar\Cookie::exists( Sonar\Config::get( "remember/cookieName" ) ) && !Sonar\Session::exists( Sonar\Config::get( "session/sessionName" ) ) )
{
    $hash = Sonar\Cookie::get( Sonar\Config::get( "remember/cookieName" ) );

    if ( Sonar\Config::get( "mysql/enabled" ) )
    {
        $hashCheck = Sonar\DB::getInstance( )->get( Sonar\Config::get( "users/usersSessionsTableName" ), array( "hash", "=", $hash ) );

        if ( $hashCheck->count( ) )
        {
            $user = new Sonar\User( $hashCheck->first( )->user_id );

            $user->login( );
        }
    }
}