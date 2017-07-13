<?php

header( "Content-type: text/css; charset: UTF-8" );

require_once( "../../classes/CSS.php" );

$cssAgent = new Sonar\CSS( );

$var = "white";

if ( 5 === 5 )
{
    //$var = $cssAgent->Tes();
}

$cssAgent->Import( "https://fonts.googleapis.com/css?family=Lobster" );

?>

*
{
    font-family: 'Lobster', cursive;
}