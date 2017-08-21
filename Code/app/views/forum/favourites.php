<?php

Sonar\Misc::ChangeWebsiteTitle( "Forum Favourites" );

$user = new Sonar\User( );

if ( !$user->IsLoggedIn( ) )
{
	Sonar\Redirect::To( "home/index" );
    
    exit( );
}

?>

<h1>
    Forum Favourites
</h1>

<?php

$forum = new Sonar\Forum( );

$favourites = $forum->GetFavourites( $user->Data( )->id );

// check if the user has favourited any questions
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