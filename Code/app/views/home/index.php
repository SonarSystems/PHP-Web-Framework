<?php

if ( Sonar\Session::exists( "home" ) )
{
    echo Sonar\Session::flash( "home" );
}

$user = new Sonar\User( );

if ( $user->isLoggedIn( ) )
{
    echo $user->data( )->username;
    
?>

<ul>
    <li><a href="<?= Sonar\Path::To( "home/logout" ); ?>">Logout</a></li>
    <li><a href="<?= Sonar\Path::To( "home/update" ); ?>">Update details</a></li>
    <li><a href="<?= Sonar\Path::To( "home/changepassword" ); ?>">Change password</a></li>
</ul>

<?php
}
else
{
    echo "You need to <a href='" . Sonar\Path::To( "home/login" ) . "'>login</a> or <a href='" . Sonar\Path::To( "home/register" ) . "'>register</a>";
}