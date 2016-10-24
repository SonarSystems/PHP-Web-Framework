<?php

$user = new Sonar\User( );
$user->logout( );

Sonar\Redirect::to( "home/index" );

?>
