<?php

Sonar\Misc::ChangeWebsiteTitle( Sonar\Config::Get( "website/title" ) );

if ( Sonar\Session::Exists( "home" ) )
{
    echo Sonar\Session::Flash( "home" );
}

$user = new Sonar\User( );

if ( $user->IsLoggedIn( ) )
{
    echo $user->Data( )->username;
    
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
    echo "You need to <a href='" . Sonar\Path::To( "home/loginhihi" ) . "'>login</a> or <a href='" . Sonar\Path::To( "home/register" ) . "'>register</a>";
}