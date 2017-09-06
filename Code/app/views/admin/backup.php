<?php

Sonar\Misc::ChangeWebsiteTitle( "Database Backup Tool" );

$user = new Sonar\User( );

if ( !$user->IsLoggedIn( ) || !$user->IsAdmin( $user->Data( )->username ) )
{
	Sonar\Redirect::To( "home/index" );
    
    exit( );
}

Sonar\DB::GetInstance( )->Backup( "backup" );
Sonar\DB::GetInstance( )->DownloadBackup( "backup" );

?>