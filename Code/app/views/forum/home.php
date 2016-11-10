Home<br /><br />

<?php

$forum = new Sonar\Forum( );

$forumSections = $forum->GetSections( );

if ( $forumSections )
{   
    foreach ( $forumSections as $row )
    {
        echo $row->title;
        echo "<br />";
    }
}
else
{
    echo "No sections available";
}

?>