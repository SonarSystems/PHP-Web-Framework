<?php

$__SHOW__ELEMENTS__ = true;

if ( isset( $_GET["__NOHTML__"] ) )
{
    if ( "false" === $_GET["__NOHTML__"] )
    {
        $__SHOW__ELEMENTS__ = false;
    }
}


if ( $__SHOW__ELEMENTS__ )
{
    require_once( "../elements/HEADER.php" );
}


require_once( "../app/init.php" );

$app = new SonarApp\App( );


if ( $__SHOW__ELEMENTS__ )
{
    require_once( "../elements/FOOTER.php" );
}