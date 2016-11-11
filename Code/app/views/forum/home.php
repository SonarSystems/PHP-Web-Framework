<h1>
    Home
</h1>

<?php

$forum = new Sonar\Forum( );

$forumSections = $forum->GetSections( );

if ( $forumSections )
{   
    foreach ( $forumSections as $row )
    {
        echo "<a href='" . Sonar\Path::To( "forum/categories/" . $row->sectionid ) . "'>" . $row->title . "</a>";
        echo "<br />";
    }
}
else
{
    echo "No sections available";
}

?>