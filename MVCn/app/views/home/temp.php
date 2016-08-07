<?php
/*
echo "<br />";

$user = new User( );

$email = new Email( );

$email = $email->send(
    array(
        "frahaanh@gmail.com",
        "thunderkeybolt@hotmail.com"
    ),
    "Subject :D",
    "test.php",
    array(
        'From: User <user@domain.com>'    
    )
);

if ( $email->passed( ) )
{
    echo "sent";
}
else
{
    echo "Failed";
}

*/?>



<?php

echo "<br />";

$user = new User( );

if ( $user->isLoggedIn( ) )
{
    echo $user->data( )->username;
    
?>

<ul>
    <li><a href="<?= Path::to( "home/logout" ); ?>">Logout</a></li>
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

<?php

echo random_int( 1, 52 );

echo "<br />";

echo bin2hex( random_bytes( 255 ) );

?>