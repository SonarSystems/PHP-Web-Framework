<?php

Sonar\Misc::ChangeWebsiteTitle( "Blog" );

// create Blog object
$blog = new Sonar\Blog( );

// get all the blog posts in descending order
$blogPosts = $blog->GetAllPosts( "desc" );

// loop over each blog post and print it out
foreach ( $blogPosts as $post )
{
    echo "<strong>" . htmlspecialchars( base64_decode( $post->title ) ) . "</strong>";
    
    echo "<br />";
    
    echo nl2br( htmlspecialchars( base64_decode( $post->body ) ) );
    
    echo "<br />";
    
    echo "<i>" . Sonar\Time::EpochToDateTime( $post->timestamp ) . "</i>";
    
    echo "<hr />";
}