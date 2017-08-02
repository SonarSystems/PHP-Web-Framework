<?php

$notifications = new Sonar\Notifications( Sonar\Config::Get( "notifications/notificationsTableName" ), Sonar\Config::Get( "notifications/notificationTypesTableName" ) );

/*if ( $notifications->Create( "like", 10, "Hello this is awesome" ) )
{
    echo "Yay";
}
else
{
    echo "Nay";
}*/

print_r( $notifications->GetAllForUser( 8, "desc", true ) );
//print_r( $notifications->GetAll("desc", true ) );

print_r( $notifications->GetAllForUserSignedInAndType( "like", "desc", true ) );

$notifications->UnmarkAsOpened( 1 );

?>