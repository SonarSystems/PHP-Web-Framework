<?php

Sonar\Misc::changeWebsiteTitle( "Forum Favourites" );

$user = new Sonar\User( );

if ( !$user->isLoggedIn( ) )
{
	Sonar\Redirect::to( "home/index" );
}

?>

<h1>
    Forum Favourites
</h1>

<?php

$forum = new Sonar\Forum( );

$favourites = $forum->GetFavourites( $user->Data( )->id );

if ( $favourites )
{   
    foreach ( $favourites as $row )
    {
        $question = $forum->GetQuestion( $row->questionid );
        
        echo "<a href='" . Sonar\Path::To( "forum/question/" . $row->questionid ) . "'>" . htmlspecialchars( base64_decode( $question->title ) ) . "</a>";
        echo "<br />";
    }
}
else
{
    echo "You have not favourited anything.";
}

$forum->EditQuestion( "14", "Updated", "Hello World" );

?>