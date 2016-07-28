<?php

$user = new User( );
$user->logout( );

Redirect::to( "home/index" );

?>