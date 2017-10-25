<?php

if ( Sonar\Config::get( "website/isAMPEnabled" ) )
{
?>
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
<?php
}
else
{
?>
    <meta charset="<?= Sonar\Config::get( "meta/charset" ); ?>" />
<?php
}

?>

<meta name="description" content="<?= Sonar\Config::get( "meta/description" ); ?>" />
<meta name="keywords" content="<?php
                               $index = 0;
                               
                               foreach( Sonar\Config::get( "meta/keywords" ) as $keyword )
                               {
                                   $index++;
                                   
                                   echo $keyword;
                                   
                                   if ( $index < count( Sonar\Config::get( "meta/keywords" ) ) )
                                   {
                                    echo ", ";
                                   }
                               }
                               ?>" />
<meta name="author" content="<?= Sonar\Config::get( "meta/author" ); ?>" />

<?php

if ( Sonar\Config::get( "website/isAMPEnabled" ) )
{
?>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<?php
}
else
{
?>
    <meta name="viewport" content="width=device-width,initial-scale=1">
<?php
}

?>
