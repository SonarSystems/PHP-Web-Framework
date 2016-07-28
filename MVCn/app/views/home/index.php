<?php

$user = new User( );

if ( $user->isLoggedIn( ) )
{
    echo $user->data( )->username;
    
?>

<ul>
    <li><a href="<?= Path::to( "home/logout" ); ?>">Logout</a></li>
    <li><a href="<?= Path::to( "home/update" ); ?>">Update details</a></li>
    <li><a href="<?= Path::to( "home/changepassword" ); ?>">Change password</a></li>
</ul>

<?php
}
else
{
    echo "You need to <a href='" . Path::to( "home/login" ) . "'>login</a> or <a href='" . Path::to( "home/register" ) . "'>register</a>";
}

?>