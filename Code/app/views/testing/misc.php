<?php

$image = new Sonar\Image( );

//print_r( $image->GifRandomSearch(  ) );

$image->GifRandomSearch( "rickandmorty" ) ;
    
$image = $image->GetAllGifURLs( "original" );

print_r( $image );

?>

<br />

<img src="<?= $image[0]; ?>" />