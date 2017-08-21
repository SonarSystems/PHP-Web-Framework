<?php

$categoryID = $data["id"];

$forum = new Sonar\Forum( );

$categoriesResult = $forum->GetCategories( $categoryID );

// check if there are any categories
if ( !$categoriesResult )
{
    Sonar\Redirect::To( "forum" );
}
else
{
    $section = $forum->GetSection( $categoryID );
    
    echo "<h1>$section->title Categories</h1>";
    
    Sonar\Misc::ChangeWebsiteTitle( "Forum - $section->title Categories" );
    
    // loop through categories and print them out
    foreach ( $categoriesResult as $row )
    {
        echo "<a href='" . Sonar\Path::To( "forum/category/" . $row->categoryid ) . "'><h3>" . $row->title . "</h3></a>";
        echo "<p>" . $row->description . "</p>";
        echo "<br />";
    }
}