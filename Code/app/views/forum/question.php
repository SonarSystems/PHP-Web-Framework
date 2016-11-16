<?php

$questionID = $data["id"];

echo $questionID . "<br />";

$user = new Sonar\User( );

$forum = new Sonar\Forum( );
$questionResult = $forum->GetQuestion( $questionID );

if ( !$questionResult )
{
    Sonar\Redirect::To( "forum" );
}

$questionTitle = nl2br( htmlspecialchars( base64_decode( $questionResult->title ) ) );

echo "<h1>$questionTitle</h1>";
    
?>

Question