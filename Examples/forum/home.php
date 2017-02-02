<h1>
    Home
</h1>

<?php

Sonar\Misc::ChangeWebsiteTitle( "Forum" );

$forum = new Sonar\Forum( );

$forumSections = $forum->GetSections( );

// check if there are any forum sections
if ( $forumSections )
{   
    // loop over sections and print them out
    foreach ( $forumSections as $row )
    {
        echo "<a href='" . Sonar\Path::To( "forum/categories/" . $row->sectionid ) . "'>" . $row->title . "</a>";
        echo "<br />";
    }
}
else
{
    echo "No sections available ATM.";
}