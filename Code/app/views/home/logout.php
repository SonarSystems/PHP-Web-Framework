<?php

$user = new Sonar\User( );
$user->Logout( );

Sonar\Redirect::To( "home/index" );