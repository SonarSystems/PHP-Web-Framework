<?php

$image = new Sonar\Image( );

//print_r( $image->GifRandomSearch(  ) );

$image->GifSearch( "rick and morty", 6 ) ;
    
$image = $image->GetAllGifURLs( "original" );

print_r( $image );

?>

<br />

<img src="<?= $image[5]; ?>" />