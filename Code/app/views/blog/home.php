<?php

$blog = new Sonar\Blog( );

$blogPosts = $blog->GetAllPosts( "desc" );

foreach ( $blogPosts as $post )
{
    echo "<strong>" . htmlspecialchars( base64_decode( $post->title ) ) . "</strong>";
    
    echo "<br />";
    
    echo nl2br( htmlspecialchars( base64_decode( $post->body ) ) );
    
    echo "<br />";
    
    echo "<i>" . Sonar\Time::EpochToDateTime( $post->timestamp ) . "</i>";
    
    echo "<hr />";
}