<?php require_once( "../elements/HEADER.php" ); ?>

<?php

echo "<br />";

$user = new User( );

if ( $user->isLoggedIn( ) )
{
    echo $user->data( )->username;
    
?>

<ul>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php
}
else
{
    echo "You need to login or register";
}

if ( Session::exists( "home" ) )
{
    echo Session::flash( "home" );
}

?>

<?php require_once( "../elements/FOOTER.php" ); ?>

<?php

echo random_int( 1, 52 );

echo "<br />";

echo bin2hex( random_bytes( 255 ) );

?>